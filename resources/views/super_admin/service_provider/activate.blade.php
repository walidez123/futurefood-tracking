@extends('layouts.master')
@section('pageTitle', 'تعيين الشركات المشغلة')
@section('css')
    <link rel="stylesheet"
        href="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
@endsection
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <style>
        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
            border-radius: 20px;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => __('admin_message.Service provider'),
            'type' => 'تفعيل',
            'iconClass' => 'fa-bookmark',
            'url' => route('defult_status.index'),
            'multiLang' => 'false',
        ])

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin_message.Name') }}</th>
                                        <th>مفعل\غير مفعل</th>
                                        <th>Auth_token</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($service_providers->currentPage() == 1) {
                                        $count = 1;
                                    } else {
                                        $count = ($service_providers->currentPage() - 1) * 25 + 1;
                                    }
                                    ?>
                                    @foreach ($service_providers as $provider)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ $provider->name }}</td>
                                        <td> 
                                            <input type="hidden" name="service_provider_id" value="{{ $provider->id }}">
                                            <input type="hidden" id="company_id_input" name="company_id" value="{{ $company->id }}">
                                            @php
                                                $isActive = false;
                                                $authtoken='';
                                                foreach ($company->companyServiceProviders as $companyServiceProvider) {
                                                    if ($companyServiceProvider->service_provider_id === $provider->id) {
                                                        $isActive = $companyServiceProvider->is_active;
                                                        $authtoken = $companyServiceProvider->auth_token;

                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <input data-id="{{ $provider->id }}" class="is_active" {{ $isActive ? 'checked' : '' }} type="checkbox">
                                        </td>
                                        <td>
                                            @if($isActive)

                                            @if($authtoken !='') {{$authtoken}}   @else  @endif 

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#authTokenModal{{ $provider->id }}">
                                                    @if($authtoken !='') Edit Auth Token @else Add Auth Token @endif 
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <?php $count++; ?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin_message.Name') }}</th>
                                        <th>مفعل\غير مفعل</th>
                                        <th>Auth_token</th>
                                    </tr>
                                </tfoot>
                            </table>
        
                            <nav>
                                <ul class="pager">
                                    {{ $service_providers->appends($_GET)->links() }}
                                </ul>
                            </nav>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
        
        <!-- Modal -->
       <!-- Modal -->
@foreach ($service_providers as $provider)
<div class="modal fade" id="authTokenModal{{ $provider->id }}" tabindex="-1" role="dialog" aria-labelledby="authTokenModalLabel{{ $provider->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="authTokenModalLabel{{ $provider->id }}">Add Auth Token</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Auth Token Form -->
                <form id="authTokenForm{{ $provider->id }}" action="{{ route('Service_provider.save_authtoken', $provider->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="authToken">Auth Token:</label>
                        <input type="text" class="form-control" id="authToken{{$provider->id}}" name="auth_token">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="saveAuthToken({{ $provider->id }})">Save</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endforeach

@endsection

@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toggle').bootstrapToggle();

        $(document).on('change', '.is_active', function() {
            var id = $(this).attr('data-id');
            var company_id = document.getElementById("company_id_input").value;

            var isChecked = $(this).prop('checked');
            var route = isChecked ? "{{ url('/super_admin/service-provider/activate') }}" : "{{ url('/super_admin/service-provider/deactivate') }}";

            $.ajax({
                url: route,
                type: 'get',
                data: {
                    service_provider_id: id,
                    company_id: company_id,
                },
                success: function(data) {
                    console.log(data.message);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });
    });
</script>

<script>
    function saveAuthToken(providerId) {
        // var authToken = $('#authTokenForm' + providerId).serialize();
        var auth_token= document.getElementById("authToken"+providerId).value;

        
        $.ajax({
            url: '/super_admin/companies/service-provider/authtoken/' + providerId,
            method: 'POST',
            data: {
                    _token:'{{ csrf_token() }}', 
                    auth_token:auth_token
            },
            success: function(response) {
                console.log(response);
                $('#authTokenModal' + providerId).modal('hide');
            },
            error: function(xhr, status, error) {
                console.error('Error saving Auth Token: ' + error);
            }
        });
    }
</script>
@endsection
