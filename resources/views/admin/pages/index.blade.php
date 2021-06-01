@extends('layouts.admin', [
  'page_header' => 'Dashboard',
  'dash' => 'active',
  'quiz' => '',
  'users' => '',
  'questions' => '',
  'top_re' => '',
  'all_re' => '',
  'sett' => ''
])

@section('content')
  <div class="box">
    <div class="box-body">
      <div class="margin-bottom">
      <a title="Create a new page" href="{{ route('pages.add') }}" class="btn btn-md btn-primary">+ Create Page</a>
        
      </div>
      
      <table id="search" class="table table-bordered">
        <thead>
          <tr>
            <th>SN</th>
            <th>Title</th>

            <th>URL</th>
            <th>Status</th>
            <th><i class="fa fa-pencil" aria-hidden="true"></i>
            </th>
            <th><i class="fa fa-trash" aria-hidden="true"></i>
            </th>
          </tr>
        </thead>

        <tbody>

          <?php $i=0;?>
          @foreach ($pages as $page)
            <?php $i++; ?>
            <tr>
              <td><?php echo $i;?></td>
              <td>{{ $page->name }}</td>

              <td><a target="_blank" href="{{ route('page.show',$page->slug) }}">{{ $page->slug }}</a></td>
              <td>
                
                   @if($page->status=="1")
                              Active
                            @else
                              Deactive
                            @endif
               
              </td>
              <td><a title="Edit" href="{{ route('pages.edit',$page->id) }}" class="btn btn-sm btn-primary">
                <i class="fa fa-pencil"></i>
              </a></td>
              <td>
                <form method="POST" action="{{ route('pages.delete',$page->id) }}">
                  {{ method_field('DELETE') }}
                  {{ csrf_field() }}
                  <button onclick="return confirm('DELETE this page?')" type="submit" class="btn btn-sm btn-danger"/><i class="fa fa-trash-o"></i></button>
                </form>
              </td>
            </tr>
          @endforeach



        </tbody>
      </table>
    </div>
    <!-- Button trigger modal -->
      

  </div>
@endsection
