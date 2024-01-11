@extends('layouts.back')

@section('content-back')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-left mb-3">
                                    <select class="form-control" name="status" id="status">
                                        <option value="all">Semua Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-right mb-3">
                                    <input type="checkbox" name="cek" id="cek"> Otomatis Refresh
                                </div> 
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-striped" id="dataTable">
            
                                <thead>
                                    <tr>
                                        <th> Status </th>
                                        <th> Tanggal </th>
                                        <th> User </th>
                                        <th> Ip Client </th>
                                        <th> Caller ID </th>
                                        <th> Uptime </th>
                                        <th> Total Active </th>
                                        <th> Service </th>
                                        <th> Last Disconnect Reason </th>
                                        <th> Last Logout </th>
                                        <th> Last Caller Id </th>
                                    </tr>
                                </thead>
            
                                <tfoot>
                                    <tr>
                                        <th> Status </th>
                                        <th> Tanggal </th>
                                        <th> User </th>
                                        <th> Ip Client </th>
                                        <th> Caller ID </th>
                                        <th> Uptime </th>
                                        <th> Total Active </th>
                                        <th> Service </th>
                                        <th> Last Disconnect Reason </th>
                                        <th> Last Logout </th>
                                        <th> Last Caller Id </th>
                                    </tr>
                                </tfoot>
            
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#status').select2({
                placeholder: 'Pilih Status',
            });

            $('#status').val('all').trigger('change');

            $('#status').change(function (e) { 
                        e.preventDefault();
                        reloadDT();
                    });
                    
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin') }}"
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all",
                }],
                columns: [{
                        data: "status",
                        name: "status",
                    },
                    {
                        data: "tanggal",
                        name: "tanggal",
                    },
                    {
                        data: "user",
                        name: "user",
                    },
                    {
                        data: "ip_client",
                        name: "ip_client",
                    },
                    {
                        data: "caller_id",
                        name: "caller_id",
                    },
                    {
                        data: "uptime",
                        name: "uptime",
                    },
                    {
                        data: "total_active",
                        name: "total_active",
                    },
                    {
                        data: "service",
                        name: "service",
                    },
                    {
                        data: "last_disconnect_reason",
                        name: "last_disconnect_reason",
                    },
                    {
                        data: "last_logout",
                        name: "last_logout",
                    },
                    {
                        data: "last_caller_id",
                        name: "last_caller_id",
                    },
                ],
                drawCallback: settings => {
                    renderedEvent();
                },preDrawCallback : settings => {
                    let status = $('#status').val();
                    settings.ajax.url = `{{ route('admin') }}?status=${status}`;
            },
            })
            const reloadDT = () => {
                $('#dataTable').DataTable().ajax.reload();
            }

            const renderedEvent = () => {
                $.each($('.delete'), (i, deleteBtn) => {
                    $(deleteBtn).off('click')
                    $(deleteBtn).on('click', function() {
                        let {
                            deleteMessage,
                            deleteHref
                        } = $(this).data();
                        confirmation(deleteMessage, function() {
                            ajaxSetup()
                            $.ajax({
                                    url: deleteHref,
                                    method: 'delete',
                                    dataType: 'json',
                                    data: {
                                        '_token': '{{ csrf_token() }}'
                                    }
                                })
                                .done(response => {
                                    let {
                                        message
                                    } = response
                                    successNotification(' Berhasil',
                                        message)
                                    reloadDT();
                                    reloadWindow();
                                })
                                .fail(error => {
                                    ajaxErrorHandling(error);
                                })
                        })
                    })
                })

            }

            $('#cek').change(function (e) { 
                e.preventDefault();
                if($(this).is(':checked')) {
                    myInterval = setInterval(() => {
                        $('#dataTable').DataTable().ajax.reload();
                    }, 5000);
                }else{
                    clearInterval(myInterval);
                } 
            });

        })
    </script>
@endsection