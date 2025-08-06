@extends('frontend.layouts.app')

@section('content')
<div class="py-4 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">

                        <div class="mb-5 text-center">
                            <h1 class="h3 text-primary mb-0">{{ translate('Create Your Account') }}</h1>
                            <p>{{ translate('Step 5 of 5: Photo Upload & Verification') }}.</p>
                        </div>
                        <form class="form-default" id="reg-form" role="form" action="{{ route('register.finalize') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="photo">{{translate('Profile Photo')}} <small>(800x800)</small></label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="photo" class="selected-files" value="{{ old('photo') }}" required>
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                        @error('photo')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="gallery_images">{{translate('Gallery Images')}} <small>(Optional, up to 7)</small></label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                            <input type="hidden" name="gallery_images" class="selected-files" value="{{ old('gallery_images') }}">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                        @error('gallery_images')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="gov_id_proof">{{translate('Government ID Proof')}} <small>(Optional)</small></label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="file">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="gov_id_proof" class="selected-files" value="{{ old('gov_id_proof') }}">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                        <small class="form-text text-muted">{{ translate('Add your Government ID proof for more valid profiles.') }}</small>
                                        @error('gov_id_proof')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="aiz-checkbox">
                                <input type="checkbox" name="checkbox_example_1" required>
                                    <span class=opacity-60>{{ translate('By signing up you agree to our')}}
                                        <a href="{{ env('APP_URL').'/terms-conditions' }}" target="_blank">{{ translate('terms and conditions')}}.</a>
                                    </span>
                                    <span class="aiz-square-check"></span>
                                </label>
                            </div>
                            @error('checkbox_example_1')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('register.step4') }}" class="btn btn-secondary">{{ translate('Previous') }}</a>
                                <button type="submit" class="btn btn-primary" id="finalize_btn">{{ translate('Finalize & Register') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#finalize_btn').on('click', function(e) {
            var profilePhoto = $('input[name="photo"]').val();
            if (!profilePhoto) {
                e.preventDefault();
                AIZ.plugins.notify('danger', '{{ translate('If you don\'t upload your photo now, potential matches may not contact you.') }}');
            }
        });
    });
</script>
@endsection