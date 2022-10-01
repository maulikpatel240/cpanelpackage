{!! Modal::start([
    'options' => ['id' => 'crudFormModal'],
    'title' => 'Create Module',
    'titleOptions' => ['id' => 'modalTitle'],
    'header' => true,
    'headerOptions' => ['id' => 'modalHeader'],
    'dialogOptions' => ['id' => 'modalDialog'],
    'bodyOptions' => ['id' => 'modalDialog'],
    'footerOptions' => ['id' => 'modalDialog'],
    'size' => 'modal-sm',
    'closeButton' => [
       'id'=>'close-button',
       'class'=>'close',
       'data-dismiss' =>'modal',
    ],
   'submitButton' => [
       'id'=>'btn-submit',
       'class'=>'btn btn-primary',
   ],
   'clientOptions' => [
       'backdrop' => false,
       'keyboard' => true
   ]
     ]) !!}
   <div class="form-group row">
       <label for="input_name" class="col-sm-2 col-form-label">Name:</label>
       <div class="col-sm-10">
           <input type="text" class="form-control" id="input_name" name="name"
                  placeholder="Enter name" value="{{ isset($user) ? $user->name : old('name')}}">
       </div>
   </div>
   <div class="form-group row">
       <label for="input_email" class="col-sm-2 col-form-label">Email:</label>
       <div class="col-sm-10">
           <input type="email" class="form-control" id="input_email"
                  name="email" placeholder="Enter email" value="{{ isset($user) ? $user->email : old('email')}}">
       </div>
   </div>
   {!! Modal::end() !!}
