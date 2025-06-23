@extends('admin.layouts.app')
@section('panel')
@section('styles')
<style>
    body { font-family: Arial, sans-serif; margin: 0; background: #f5f5f5; }
    .tabs { display: flex; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .tab { padding: 15px 20px; cursor: pointer; border-bottom: 3px solid transparent; display: flex; align-items: center; gap: 6px; }
    .tab:hover, .tab.active { border-bottom: 3px solid #f4a300; background: #fafafa; }
    .content { padding: 30px; }
    .section { margin-bottom: 40px; }
    .section h2 { color: #f4a300; margin-bottom: 20px; }
    .upload-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
    .upload-box {
      background: #fff;
      border: 2px dashed #ccc;
      border-radius: 8px;
      text-align: center;
      padding: 20px;
      height: 150px;
      position: relative;
    }
    .upload-box.error { border-color: red; color: red; }
    .upload-box input { display: none; }
    .upload-box label { cursor: pointer; display: block; color: #777; }
    .upload-box img { max-width: 80px; display: block; margin: 0 auto 10px; }
    .tab-content {
    display: none;
        }
        .tab-content.active {
            display: block;
        }
  </style>
@endsection
@php
    $activeTab = session('submit_tab', 'general_settings'); // default to general_settings
@endphp
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="nav-icon fas fa-cogs"></i></i> @lang('Settings')</h3>
                    </div>
                    <div class="tabs">
                        <div class="tab {{ $activeTab == 'general_settings' ? 'active' : '' }}" data-target="#general_settings">⚙️ General Settings</div>
                        <div class="tab {{ $activeTab == 'theme_settings' ? 'active' : '' }}" data-target="#theme_settings">🎨 Theme Settings</div>
                        <div class="tab {{ $activeTab == 'logo_settings' ? 'active' : '' }}" data-target="#logo">🖼️ Logo</div>
                        <div class="tab {{ $activeTab == 'upload_file_settings' ? 'active' : '' }}" data-target="#upload_file_settings">📁 Upload File Settings</div>
                    </div>

                    {{-- General Settings --}}
                    <div id="general_settings" class="tab-content {{ $activeTab == 'general_settings' ? 'active' : '' }}" style="{{ $activeTab != 'general_settings' ? 'display: none;' : '' }}">
                        <form action="{{ route('admin.settings.store') }}" class="frm-submit-data" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="submit_tab" value="general_settings">
                                <div class="row">
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Institute Name')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-school"></i></span>
                                                <input type="text" name="institute_name" class="form-control" value="{{ old('institute_name', $general->institute_name??'') }}" placeholder="@lang('Institute Name')">                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Institution Code')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-code"></i></span>
                                                <input type="text" name="institution_code" class="form-control" value="{{ old('institution_code', $general->institution_code??'') }}"  placeholder="@lang('Institution Code')">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Mobile No')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input type="text" name="mobile_no" class="form-control" value="{{ old('mobile_no', $general->mobile_no??'') }}" placeholder="@lang('Mobile No')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Address')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                <textarea name="address" class="form-control">{{ old('address', $general->address ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Email')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" name="email" class="form-control" value="{{ old('email', $general->email??'') }}" placeholder="@lang('Enter email')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Currency')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                                <input type="text" name="currency" class="form-control" value="{{ old('currency', $general->currency??'') }}" placeholder="@lang('Currency')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Currency Symbol')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $general->currency_symbol??'') }}" placeholder="@lang('Currency Symbol')">
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $selectedFormat = old('currency_format', $general->currency_format??'');
                                    @endphp
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Currency Formats')<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                                            <select class="form-control" id="currencyFormat" name="currency_format" required>
                                                <option value="">Select</option>
                                                @foreach (currency_formats() as $key => $label)
                                                    <option value="{{ $key }}" {{ $selectedFormat == $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $selectedSymbol = old('symbol_position', $general->symbol_position??'');
                                    @endphp
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Symbol Position')<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                            <select class="form-control" id="currencyFormat" name="symbol_position" required>
                                                <option value="">Select</option>
                                                @foreach (symbol_positions() as $key => $label)
                                                    <option value="{{ $key }}" {{ $selectedSymbol == $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Language')</label>
                                            <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-language"></i></span>
                                            <select class="form-control" id="currencyFormat" name="language">
                                                <option value="">Select</option>
                                                <option value="english" {{ ($general->language??'') == 'english' ? 'selected' : '' }}>English</option>
                                                <option value="hindi" {{ ($general->language??'') == 'hindi' ? 'selected' : '' }}>Hindi</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Academic Session')<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <select class="form-control" id="currencyFormat" name="academic_session_id" required>
                                                <option value="">Select</option>
                                                @foreach($sessions as $session)
                                                    <option value="{{ $session->id }}" {{ ($general->academic_session_id??'' == $session->id) ? 'selected' : '' }}>{{ $session->session }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Timezone')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                <select class="form-control" name="timezone">
                                                    @php
                                                        $indianTimezones = [
                                                            'Asia/Kolkata' => '(GMT+05:30) Asia/Kolkata',
                                                            // Add more if needed
                                                        ];
                                                    @endphp

                                                    @foreach ($indianTimezones as $value => $label)
                                                        <option value="{{ $value }}" {{ ($general->timezone??'') == $value ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $selectedFormat = old('date_format', $general->date_format??'');
                                    @endphp
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Date Format')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                <select class="form-control" id="dateFormat" name="date_format">
                                                    <option value="">Select</option>
                                                    @foreach(date_formats() as $format => $label)
                                                        <option value="{{ $format }}" {{ ($selectedFormat == $format??'') ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Footer Text')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-quote-right"></i></span>
                                                <input type="text" name="footer_text" class="form-control" value="{{ old('footer_text', $general->footer_text??'') }}" placeholder="@lang('Footer Text')"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Facebook URL')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                                <input type="text" name="facebook_url" class="form-control" value="{{ old('facebook_url', $general->facebook_url??'') }}" placeholder="@lang('Facebook URL')"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Twitter URL')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                                <input type="text" name="twitter_url" class="form-control" value="{{ old('twitter_url', $general->twitter_url??'') }}" placeholder="@lang('Twitter URL')"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Linkedin URL')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                                <input type="text" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $general->linkedin_url??'') }}" placeholder="@lang('Linkedin URL')"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Youtube URL')</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                                <input type="text" name="youtube_url" class="form-control" value="{{ old('youtube_url', $general->youtube_url??'') }}" placeholder="@lang('Youtube URL')"> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing" class="btn btn-sm btn-primary d-feex justify-content-end">
                                    <i class="fas fa-plus-circle"></i> @lang('Save')
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Theme Settings --}}
                    <div id="theme_settings" class="tab-content" style="display: none;">
                        <form>
                            ...
                        </form>
                    </div>

                    {{-- Logo --}}
                    <div id="logo" class="tab-content {{ $activeTab == 'logo_settings' ? 'active' : '' }}" style="{{ $activeTab != 'logo_settings' ? 'display: none;' : '' }}">
                        <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="submit_tab" value="logo_settings">
                            <div class="card-body">
                                <div class="headers-line mt-md"><i class="fas fa-leaf text-warning"></i> @lang('Logo')</div>
                                <div class="row mb-4">
                                    @foreach(['system_logo' => 'System Logo', 'text_logo' => 'Text Logo', 'printing_logo' => 'Printing Logo', 'report_card_logo' => 'Report Card'] as $key => $label)
                                        <div class="col-md-3 mb-3">
                                            <div class="card h-100">
                                                <div class="card-header">{{ $label }}</div>
                                                <div class="card-body text-center">
                                                    <img id="preview_{{ $key }}" src="{{ ($general->$key??'' !='') ? asset('storage/' . $general->$key) : asset('admin\images\placeholder-image.jpg') }}" class="img-fluid mb-2" alt="{{ $label }}">                                                    <input type="file" class="form-control mt-2 file-input" name="{{ $key }}" data-preview="#preview_{{ $key }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="headers-line mt-md"><i class="fas fa-sign-in-alt text-warning"></i> @lang('Login Background')</div>
                                <div class="row mb-4">
                                    @foreach(['slider1' => 'Slider 1', 'slider2' => 'Slider 2', 'slider3' => 'Slider 3'] as $key => $label)
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100">
                                                <div class="card-header">{{ $label }}</div>
                                                <div class="card-body text-center">
                                                    <img id="preview_{{ $key }}" src="{{ ($general->$key??'' !='') ? asset('storage/' . $general->$key) : asset('admin\images\placeholder-image.jpg') }}" class="img-fluid mb-2" alt="{{ $label }}"> 
                                                    <input type="file" class="form-control mt-2 file-input" name="{{ $key }}" data-preview="#preview_{{ $key }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="card-footer">
                                    <button type="submit" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing" class="btn btn-sm btn-primary d-feex justify-content-end">
                                        <i class="fas fa-upload"></i> @lang('Upload')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Upload File Settings --}}
                    <div id="upload_file_settings" class="tab-content {{ $activeTab == 'upload_file_settings' ? 'active' : '' }}" style="{{ $activeTab != 'upload_file_settings' ? 'display: none;' : '' }}">
                        <form action="{{ route('admin.settings.store') }}" class="frm-submit-data" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                <input type="hidden" name="submit_tab" value="upload_file_settings">
                                <div class="headers-line mt-md"><i class="fas fa-images text-warning"></i> @lang('Settings For Image')</div>
                                <div class="row">
                                    <div class="col-md-12 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Allowed Extension')<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-file-image"></i></span>
                                                <textarea name="image_extension" class="form-control" required>{{ old('image_extension', $general->image_extension ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-md-12 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Upload Size (in KB)')<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-ruler-combined"></i></span>
                                                <input type="text" name="image_size" class="form-control" value="{{ old('image_size', $general->image_size ?? '') }}" placeholder="@lang('Upload Size (in KB)')" required>                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="headers-line mt-md"><i class="far fa-folder-open text-warning"></i> @lang('Settings For Files')</div>
                                <div class="row">
                                    <div class="col-md-12 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Allowed Extension')<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                <textarea name="file_extension" class="form-control" required>{{ old('file_extension', $general->file_extension ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-md-12 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Upload Size (in KB)')<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                                <input type="text" name="file_size" class="form-control" value="{{ old('file_size', $general->file_size ?? '') }}" placeholder="@lang('Upload Size (in KB)')" required>                                        
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing" class="btn btn-sm btn-primary d-feex justify-content-end">
                                    <i class="fas fa-plus-circle"></i> @lang('Save')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.file-input').forEach(function(input) {
        input.addEventListener('change', function(e) {
            const previewId = this.getAttribute('data-preview');
            const file = this.files[0];

            if (file && previewId) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector(previewId).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
    document.querySelectorAll('.tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));

            // Add active class to clicked tab
            this.classList.add('active');

            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');

            // Show the associated tab content
            const target = this.getAttribute('data-target');
            const targetContent = document.querySelector(target);
            if (targetContent) {
                targetContent.style.display = 'block';
            }
        });
    });

</script>
@endsection