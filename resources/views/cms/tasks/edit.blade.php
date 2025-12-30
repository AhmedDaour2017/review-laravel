@extends('cms.parent')

@section('title','Edit-Task')
@section('page-name','Edit Task')
@section('small-name','task')


@section('style')
    
@endsection




@section('content')
    
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Task</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="create_form">
                        @csrf
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" value="{{$task->title}}" id="title" placeholder="add title">
                                </div>

                                <div class="form-group col-md-6">
                                <label>Status</label>
                                <select class="form-control" name="status_id" id="status_id" style="width: 100%;">
                                  {{-- @foreach ($status as $statuses)
                                  <option value="{{$statuses->id}}">{{$task->status->name}}</option>
                                  @endforeach --}}

                                  @foreach ($status as $statuses)

                                <option @if($statuses->id==$task->status_id)selected @endif value="{{$statuses->id}}">{{$statuses->name}}
                                </option>

                         @endforeach

                                </select>
                                </div>
                            </div>


                                <div class="row">

                                <div class="form-group col-md-6">
                                 <label>Priority</label>
                                 <select class="form-control" name="priority" id="priority">
                                    <option value="" disabled selected>Choose priority</option>
                                    <option value="low" @if($task->priority == 'low') selected @endif>Low</option>
                                    <option value="medium" @if($task->priority == 'medium') selected @endif>Medium</option>
                                    <option value="high" @if($task->priority == 'high') selected @endif>High</option>
                                </select>
                                </div>

                                    <div class="form-group col-md-6">
                                        <label for="" class="mb-2">Due Date</label>
                                        <input type="date" class="form-control" id="due_date" name="due_date"
                                        value="{{ $task->due_date->format('Y-m-d') }}" placeholder=" add due_date">
                                    </div>
                                 </div>



                                 <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" style="resize: none;" id="description"
                                                name="description" rows="4" placeholder="add description"
                                                 cols="50">{{$task->description}}"</textarea>
                                        </div>
                                    </div>
                                    </div>

                        </div>

                          
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" onclick="performUpdate({{$task->id}})" class="btn btn-md btn-success">Edit</button>
                                <a href="{{route('tasks.index')}}"><button type="button" class="btn btn-md btn-primary">View Task</button></a>
                            </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection



@section('script')

<script src="{{asset('crudjs/crud.js')}}"></script>

<script>

        function performUpdate(id){

        let data = {
            status_id: document.getElementById('status_id').value,
            title: document.getElementById('title').value,
            description: document.getElementById('description').value,
            due_date: document.getElementById('due_date').value,
            priority: document.getElementById('priority').value,
        };

        update('/cms/admin/tasks/'+id,data,'/cms/admin/tasks');

    }
</script>

@endsection