@extends('cms.parent')

@section('title','Index-Task')
@section('page-name','Index Task')
@section('small-name','task')

@section('style')
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <!-- Filter Row -->
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" id="search" class="form-control" placeholder="Search..." onkeyup="filterTasks()">
        </div>

        <div class="col-md-3">
            <select id="status_id" class="form-control" onchange="filterTasks()">
                <option value="">All Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select id="priority" class="form-control" onchange="filterTasks()">
                <option value="">All Priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
    </div>

    <!-- Table Card -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>UserName</th>
                  <th>Title</th>
                  <th>Priority</th>
                  <th>Status</th>
                  <th>DueDate</th>
                  <th>CreatedAt</th>
                  <th>Settings</th>
                </tr>
              </thead>
              <tbody id="tasks_table">
                  @foreach ($tasks as $task)
                      <tr>
                          <td>{{$task->id}}</td>
                          <td>{{$task->user->name}}</td>
                          <td>{{$task->title}}</td>
                          <td>{{$task->priority}}</td>
                          <td><span class="tag tag-danger">{{$task->status->name}}</span></td>
                          <td>{{$task->due_date}}</td>
                          <td>{{$task->created_at}}</td>
                          <td>
                              <div class="btn-group">
                                  <a href="{{route('tasks.edit',$task->id)}}" class="btn btn-info" style="margin-left: 3px;">edit</a>
                                  <a href="#" onclick="performDestroy({{$task->id}}, this)" class="btn btn-danger">
                                      <i class="fa fa-trash"></i>
                                  </a>
                              </div>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      {{ $tasks->links('pagination::bootstrap-5') }}
    </div>

  </div><!-- /.container-fluid -->
</section>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
  function performDestroy(id, reference){
      let url = '/cms/admin/tasks/' + id;
      confirmDestroy(url, reference);
  }

  function filterTasks() {
      axios.get("{{ route('tasks.filter') }}", {
          params: {
              search: document.getElementById('search').value,
              status_id: document.getElementById('status_id').value,
              priority: document.getElementById('priority').value,
          }
      })
      .then(response => {
          let tasks = response.data.tasks;
          let tbody = document.getElementById('tasks_table');
          tbody.innerHTML = '';

          if (tasks.length === 0) {
              tbody.innerHTML = `
                  <tr>
                      <td colspan="8" class="text-center">No Tasks Found</td>
                  </tr>
              `;
              return;
          }

          tasks.forEach(task => {
              tbody.innerHTML += `
                  <tr>
                      <td>${task.id}</td>
                      <td>${task.user.name}</td>
                      <td>${task.title}</td>
                      <td>${task.priority}</td>
                      <td><span class="tag tag-danger">${task.status.name}</span></td>
                      <td>${task.due_date}</td>
                      <td>${task.created_at}</td>
                      <td>
                          <div class="btn-group">
                              <a href="/cms/admin/tasks/${task.id}/edit" class="btn btn-info" style="margin-left: 3px;">edit</a>
                              <a href="#" onclick="performDestroy(${task.id}, this)" class="btn btn-danger">
                                  <i class="fa fa-trash"></i>
                              </a>
                          </div>
                      </td>
                  </tr>
              `;
          });
      })
      .catch(error => {
          console.error(error);
      });
  }
</script>
@endsection
