<?php

if(version_compare(PHP_VERSION, '7.2.0','>=')){
  error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

}
use App\User;
use App\Topic;
use App\Answer;
use App\Friend;
use App\copyrighttext;
use App\Question;
use App\Friend_invite;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'home');
Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes();

/*google login route*/
// Route::get('login/o_auth/facebook  ', 'Auth\LoginController@redirectToProvider');
// Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');



/*Social Login*/
Route::get('login/{service}', 'Auth\LoginController@redirectToProvider')->name('sociallogin');
Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');


/*facebook login route*/

// Route::get('login/google', 'Auth\LoginController@redirectToProvider');
// Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/faqs',function(){
  return view('faq');
})->name('faq.get');

Route::get('/levelscreen',function(){
  return view('levelscreen');
});


Route::post('/topics', 'HomeController@index2')->name('level.screen');


Route::get('/home', function(){
  $topics = Topic::all();
  $questions = Question::all();
  if (Auth::check()) {
    return view('levelscreen');
  }
  else{
  return view('home', compact('topics', 'questions'));
}
});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '1',
        'redirect_uri' => 'http://example.com/callback',
        'response_type' => 'token', 
        'scope' => '',
    ]);

    return redirect('http://your-app.com/oauth/authorize?'.$query);
});

Route::group(['middleware'=> 'isadmin'], function(){

  Route::delete('delete/sheet/quiz/{id}','TopicController@deleteperquizsheet')->name('del.per.quiz.sheet');

  Route::get('/admin', function(){

    $user = User::where('role', '!=', 'A')->count();
    $question = Question::count();
    $quiz = Topic::count();
    $user_latest = User::where('id', '!=', Auth::id())->orderBy('created_at', 'desc')->get();

    return view('admin.dashboard', compact('user', 'question', 'quiz', 'user_latest'));
    //remove the answer line comment
    // return view('admin.dashboard', compact('user', 'question', 'answer', 'quiz', 'user_latest'));

  });

  Route::delete('reset/response/{topicid}/{userid}','AllReportController@delete');

  Route::resource('/admin/all_reports', 'AllReportController');
  Route::resource('/admin/top_report', 'TopReportController');
  Route::resource('/admin/topics', 'TopicController');
  Route::resource('/admin/questions', 'QuestionsController');
  Route::post('/admin/questions/import_questions', 'QuestionsController@importExcelToDB')->name('import_questions');
  Route::resource('/admin/answers', 'AnswersController');
  Route::resource('/admin/settings', 'SettingController');


  Route::post('/admin/users/destroy', 'DestroyAllController@AllUsersDestroy');
  Route::post('/admin/answers/destroy', 'DestroyAllController@AllAnswersDestroy');

});

Route::resource('/admin/users', 'UsersController');
Route::get('/admin/profile', function(){
  if (Auth::check()) {
    return view('admin.users.profile');
  } else {
    return redirect('/');
  }
});
Route::get('/admin/my_reports', 'MyReportsController@index')->name('my_report');
Route::get('/admin/my_reports/{my_reports}', 'MyReportsController@show')->name('my_report_show');


Route::get('start_quiz/{id}', function($id){
  $topic = Topic::findOrFail($id);
  $answers = Answer::where('topic_id','=',$topic->topic_id)->first();
  return view('main_quiz', compact('topic','answers'));
})->name('start_quiz');


Route::get('admin/myfriend', function(){
  $user = Auth::user();
  $Friends = Friend::whereRaw('FIND_IN_SET(?,user_id)', [$user->id])->get();
  return view('admin.friends.show', compact('Friends'));
})->name('myfriend');

Route::get('admin/addfriend', function(){
  $users = User::where('id','!=',Auth::user()->id)->orderBy('id','desc')->get();
  return view('admin.friends.index', compact('users'));
})->name('addfriend');


Route::post('admin/addpostfriend', 'MyReportsController@addpostfriend')->name('addpostfriend');




Route::get('/start-screen', 'HomeController@start_screen')->name('start_screen');
Route::get('/user/achievements', 'HomeController@user_achievements')->name('user.achievements');
Route::get('/admin/achievements', 'HomeController@admin_achievements')->name('admin.achievements');
Route::post('/add/new/achievement', 'HomeController@addnewachievement')->name('add.new.achievement');
Route::get('/delete/achievement/{id}', 'HomeController@delete_achievement')->name('delete.achievement');


Route::resource('start_quiz/{id}/quiz', 'MainQuizController');
Route::post('{id}/quiz', 'MainQuizController@store');
Route::get('{fid}/quiz/{id}', 'MainQuizController@showw');
Route::post('/invite_friend', 'MainQuizController@invite_friend')->name('invite_friend');
Route::post('/joinquiz', 'MainQuizController@joinquiz')->name('joinquiz');


Route::get('invite_friend', function(){
  
  return redirect('/');
});
Route::get('joinquiz', function(){
  
  return redirect('/');
});
Route::get('/admin/myinvites', 'MainQuizController@myinvites')->name('myinvites');
Route::get('/admin/sendedinvites', 'MainQuizController@sendedinvites')->name('sendedinvites');

Route::get('start_quiz/{id}/finish', function($id){
  $auth = Auth::user();
  $topic = Topic::findOrFail($id);
  $dlevel = Session::get('dlevel');
  $questions = Question::where('topic_id', $id)->where('type',$dlevel)->get();
  $count_questions = $questions->count();
  $answers = Answer::where('user_id',$auth->id)
              ->where('topic_id',$id)->get(); 
              if(count($questions)!=count($answers)){
                $url = "$id/finish";
                return redirect($url);
              }

  // if($count_questions != $answers->count()){
  //   foreach($questions as $que){ 
  //     $a = false;   
  //     foreach($answers as $ans){ 
  //       if($que->id == $ans->question_id){ 
  //         $a = true;
  //       }
  //     }
  //     if($a == false){  
  //       Answer::create([
  //         'topic_id' => $id,
  //         'user_id' => $auth->id,
  //         'question_id' => $que->id,
  //         'user_answer' => 0,
  //         'answer' => $que->answer,
  //       ]);
  //     }
  //   }
  // }

  $ans= Answer::all();
  $q= Question::all();
  
  return view('finish', compact('ans','q','topic', 'answers', 'count_questions'));
});

Route::get('{id}/finish', function($id){
  $auth = Auth::user();
  $topic = Topic::findOrFail($id);
  $dlevel = Session::get('dlevel');
  $questions = Question::where('topic_id', $id)->where('type',$dlevel)->get();
  $count_questions = $questions->count();
  $answers = Answer::where('user_id',$auth->id)
              ->where('topic_id',$id)->get(); 
  // if(count($questions)!=count($answers)){
  //   $url = "$id/finish";
  //   echo $url;
  //   die;
  //   return redirect($url);
  // }
  $marks = $topic->per_q_mark;
  $total_marks = 0;
  foreach($answers as $answer){
    if($answer->user_answer== $answer->answer){
      $total_marks = $total_marks +$marks;
    }
  }
  $friend_marks = NULL;
  $chat_id = Session::get('chat_id');
  // dd($chat_id);
  if($chat_id){
    $Friend_invite = Friend_invite::findOrFail($chat_id);

    $friend_marks = "-1";
    if($Friend_invite->user_id==$auth->id){
      $Friend_invite->user_score=$total_marks;
      $friend_marks = $Friend_invite->friend_score;
    }else if($Friend_invite->friend_id==$auth->id){
      $Friend_invite->friend_score=$total_marks;
      $friend_marks = $Friend_invite->user_score;
    }
    $Friend_invite->save();
    // dd($topic,$questions,$answers,$Friend_invite);
  }
  

  $ans= Answer::all();
  $q= Question::all();
  
  return view('finish', compact('ans','q','topic', 'answers', 'count_questions','friend_marks'));
});

Route::get('/admin/pages','PagesController@index')->name('pages.index');

Route::get('/admin/pages/add','PagesController@add')->name('pages.add');

Route::post('/admin/pages/add','PagesController@store')->name('pages.store');

Route::get('pages/{slug}','PagesController@show')->name('page.show');


Route::get('/admin/pages/edit/{id}','PagesController@edit')->name('pages.edit');

Route::put('/admin/pages/edit/{id}','PagesController@update')->name('pages.update');

Route::delete('/delete/pages/{id}','PagesController@destroy')->name('pages.delete'); 




Route::get('admin/moresettings/faq/','FAQController@index')->name('faq.index');
Route::get('admin/moresettings/faq/add','FAQController@create')->name('faq.add');
Route::post('/admin/moresettings/faq/insert','FAQController@store')->name('faq.store');
Route::get('/admin/moresettings/faq/edit/{id}','FAQController@edit')->name('faq.edit');
Route::put('/admin/moresettings/faq/edit/{id}','FAQController@update')->name('faq.update');
Route::delete('/faq/delete/{id}','FAQController@destroy')->name('faq.delete');




Route::get('admin/moresettings/copyright','CopyrighttextController@index')->name('copyright.index');

Route::put('admin/moresettings/copyright/{id}','CopyrighttextController@update')->name('copyright.update');



Route::get('admin/moresettings/socialicons/','SocialController@index')->name('socialicons.index');
Route::post('/admin/moresettings/socialicons/insert','SocialController@store')->name('social.store');
 Route::put('/admin/moresettings/socialicons/active/{id}','SocialController@active')->name('social.active');
 Route::put('/admin/moresettings/socialicons/deactive/{id}','SocialController@deactive')->name('social.deactive');
 Route::delete('/admin/moresettings/socialicons/delete/{id}','SocialController@destroy')->name('social.delete');
//env.
 Route::get('/admin/mail-settings','Configcontroller@getset')->name('mail.getset');
 Route::post('admin/mail-settings', 'Configcontroller@changeMailEnvKeys')->name('mail.update');

   Route::get('/admin/custom-style-settings', 'CustomStyleController@addStyle')->name('customstyle');
    Route::post('/admin/custom-style-settings/addcss','CustomStyleController@storeCSS')->name('css.store');
    Route::post('/admin/custom-style-settings/addjs','CustomStyleController@storeJS')->name('js.store');
//payment getway
 Route::get('/admin/mail','ApiController@setApiView')->name('api.setApiView');
  Route::post('/admin/mail','ApiController@changeEnvKeys')->name('api.update');

  Route::get('admin/sociallogin/','ApiController@facebook')->name('set.facebook');

  Route::post('admin/facebook','ApiController@updateFacebookKey')->name('key.facebook');

  Route::post('admin/google','ApiController@updateGoogleKey')->name('key.google');

  Route::post('admin/gitlab','ApiController@updategitlabKey')->name('key.gitlab');

  
  Route::delete('admin/ans/{id}','Anscontroller@destroy')->name('ans.del');

  Route::get('/admin/payment', 'PaymentController@index')->name('admin.payment');

// route for processing payment







   Route::post('payment/paypal_post', 'PaypalController@paypal_post')->name('paypal_post');
  // Handle status
  Route::get('payment/paypal_success', 'PaypalController@paypal_success')->name('paypal_success');
  Route::get('payment/paypal_cancel', 'PaypalController@paypal_cancel')->name('paypal_cancel');





  
  Route::get('sendmessage', 'ChatController@sendmessage')->name('sendmessage');

Route::get('refreshchat', 'ChatController@refreshchat')->name('refreshchat');
Route::get('refresquestion', 'ChatController@refresquestion')->name('refresquestion');
