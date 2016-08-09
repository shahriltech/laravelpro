@extends('layouts.app') <!--  informs Blade that we are using the layout we defined at resources/views/layouts/app.blade.php -->
@section('content') <!-- injected into the yield('content') -->
<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
	@include('flash::message')
	@include('common.errors') <!-- directive will load the template located at resources/views/common/errors.blade.php -->
	<form url="{{ url ('tasks') }}" method="POST" class="form-horizontal">
		{{csrf_field()}}
		<!--task name -->
		<div class="form-group">
			<label for="task-name" class="col-sm-3 control-label" >Task</label>
			<div class="col-sm-6">
				<input type="text" name="name" id="task-name" class="form-control">
			</div>
		</div>
		<!-- Add button -->
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-6">
				<button type="submit" class="btn btn-default">
					<i class="fa fa-plus"></i>Add Task
				</button>
			</div>
		</div>
	</form>

	@if (count($tasks) > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				Current Tasks
			</div>
			<div class="panel-body">
				<table class="table table-striped task-table">
					<thead>
						<th>Task</th>
						<th>&nbsp;</th>
					</thead>
					<tbody>
						@foreach ($tasks as $task)
							<tr>
								<td class="table-text">
									<div>{{ $task->name }}</div>
								</td>
								<td>
									<form action="{{ url('task/'.$task->id) }}" method="POST">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}

										<button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
											<i class="fa fa-btn fa-trash">Delete</i>
										</button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

	@endif
</div>
@endsection