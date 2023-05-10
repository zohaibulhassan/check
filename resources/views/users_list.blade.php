@extends('layouts.app')
@section('content')
<div class="page_container">

    <div class="page_container">
    <div id="success-alert" class="alert alert-success" style="display: none;">
        <center><i class="fa fa-check-circle" aria-hidden="true"></i> Your company is mapped, and the Excel sheet is downloaded on this system. Please upload the data.</center>
        <center><a href="{{ url('uploaddata') }}">Click here to upload</a></center>
    </div>

    
    <button id="createCompanyBtn" class="btn btn-success">Create Company</button>
<table class="table table-striped table-bordered nowrap">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Company Name</th>
            <th>Registration No</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        @if($user->user_type == 'a')
            <tr>
                
                <td>{{ $loop->iteration }}</td>
                <td>(ME) {{ $user->company_name }}</td>
                <td>{{ $user->registration_no }}</td>
                <td>
                @if($user->user_status == 'p')
                    <form action="{{ route('approve_user', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit">Approve</button>
                    </form>
                    <form action="{{ route('reject_user', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Reject</button>
                    </form>
                @elseif($user->user_status == 'a')
                    <a href="#">Approved</a>
                @else
                    <a href="#">Reject</a>
                @endif
            </td>
            </tr>   
            @continue   
        @endif
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->company_name }}</td>
            <td>{{ $user->registration_no }}</td>
            <td>
                @if($user->user_status == 'p')
                    <form action="{{ route('approve_user', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit">Approve</button>
                    </form>
                    <form action="{{ route('reject_user', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Reject</button>
                    </form>
                @elseif($user->user_status == 'a')
                    <a href="#">Approved</a>
                @else
                    <a href="#">Reject</a>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>

</table>
</div>




<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">{{ __('Register') }}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCloseBtn">
    <span aria-hidden="true">&times;</span>
</button>
            </div>
            <div class="modal-body">
                <!-- Registration form fields go here -->
               <form method="POST" action="{{url('registermodal') }}">
                    @csrf
                    <!-- Add your registration form fields here -->
                  <div class="row mb-3">
                           <label for="company_name" class="col-md-4 col-form-label text-md-end">{{ __('Company Name') }}</label>

                                   <div class="col-md-6">
                                       <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name" autofocus>
        
                                                   @error('company_name')
                                                       <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                            </div>
                       </div>
 
                        <div class="row mb-3">
                           <label for="country" class="col-md-4 col-form-label text-md-end">{{ __('Country') }}</label>
 
                            <div class="col-md-6">
                               <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" autocomplete="country">
 
                                @error('country')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                               @enderror
                           </div>
                        </div>
 
                        <div class="row mb-3">
                            <label for="state" class="col-md-4 col-form-label text-md-end">{{ __('State') }}</label>
 
                           <div class="col-md-6">
                                <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" autocomplete="state">
 
                               @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message }}</strong>
                                   </span>
                                @enderror
                            </div>
                       </div>

                       <div class="row mb-3">
                           <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City') }}</label>

                           <div class="col-md-6">
                               <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" autocomplete="city">

                   
             @error('city')
                                   <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
               
                     </span>
                               @enderror
                            </div>
                         
    /
div>
 
                        <div class="row mb-3">
                            
     
<label for="registration_no" class="col-md-4 col-form-label text-md-end">{{ __('Registration No') }}</label>
 
                            <div class="col-md-6">
                              
     
  <input id="registration_no" type="text" class="form-control @error('registration_no') is-invalid @enderror" name="registration_no" value="{{ old('registration_no') }}" required autocomplete="registration_no">
 
                                @error('registration_no')
                     
               <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                              
     
  @enderror
</div>
                        </div>
 
    

                                               <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>


                           <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
 
    

                               @error('email')
                                    <span class="invalid-feedback" role="alert">
                   
                     <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
               
             </div>
                        </div>

                        <div class="row mb-3">
     <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
                                            
                           
                     <div class="col-md-6">
                                           
                                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone">
                

                   
                                
                      
                                     @error('phone')
                                                   
               
                    
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            


                    @enderror
                   
         </div>
                        </d
iv>
                   
     
<div class="row
 mb-3">


    <label for="zipcode" class="col-md-4 col-form-label text-md-end">{{ __('Zip Code') }}</label>

    <div class="col-md

-6">

        <input id="z
ipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode') }}" autocomplete="zipcode">


   

           @error('zipcode')
   


               <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>



        @enderror

       </div>

   </div>

   
   




                       
 


                      
  <div class="row mb-3">
                    
        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>


                            <div class="col-md-6">
                    
            <input id="password" ty
pe="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                    
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    
            @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>


                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                       
     </div>
                        </div>



                        <div class="row mb-3">
                   <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
               

               
                   <div class="col-md-6">
         <textarea id=
"address" class="form-control @error('address') is-invalid @enderror" name="address" autocomplete="address">{{ old('address') }}</textarea>
 
 
         @error('address')

                             <span class="invalid-feedback" role="alert">
                                 <strong
                 >{{ $message }}</strong>
                             </span>
                         @enderror
                     </div>
                 
                 </div>


                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="terms_and_conditions" id="terms_and_conditions" {{ old('terms_and_conditions') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="terms_and_conditions">
                                        {{ __('I agree to the terms and conditions') }}
                                    </label>

                                    @error('terms_and_conditions')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Your JavaScript/jQuery code -->
<script>
    $(document).ready(function() {
        $('#createCompanyBtn').click(function(e) {
            e.preventDefault(); // Prevent the default link behavior

            // Show the modal
            $('#registerModal').modal('show');
        });

        $('#modalCloseBtn').click(function(e) {
            // Hide the modal
            $('#registerModal').modal('hide');
        });
    });
</script>



@endsection
