@extends('cms.parent')

@section('title','Create-Task')
@section('page-name','Create Task')
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
                        <h3 class="card-title">Add Task</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="create_form">
                        @csrf
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="add title">
                                </div>

                                <div class="form-group col-md-6">
                                <label>Status</label>
                                <select class="form-control" name="status_id" id="status_id" style="width: 100%;">
                                  @foreach ($status as $statuses)
                                  <option value="{{$statuses->id}}">{{$statuses->name}}</option>
                                  @endforeach
                                </select>
                                </div>
                            </div>


                                <div class="row">

                                <div class="form-group col-md-6">
                                 <label>Priority</label>
                                 <select class="form-control" name="priority" id="priority">
                                    <option value="" disabled selected>Choose priority</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                </div>

                                    <div class="form-group col-md-6">
                                        <label for="" class="mb-2">Due Date</label>
                                        <input type="date" class="form-control" id="due_date" name="due_date" placeholder=" add due_date">
                                    </div>
                                 </div>



                                 <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" style="resize: none;" id="description"
                                                name="description" rows="4" placeholder="add description"
                                                cols="50"></textarea>
                                        </div>
                                    </div>
                                    </div>

                        </div>

                          
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" onclick="performStore()" class="btn btn-md btn-success">Save</button>
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

<script>
    function performStore() {
        let formData = new FormData();
        formData.append('status_id', document.getElementById('status_id').value);
        formData.append('title', document.getElementById('title').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('due_date', document.getElementById('due_date').value);
        formData.append('priority', document.getElementById('priority').value);
        store('/cms/admin/tasks', formData)
    }
</script>

@endsection