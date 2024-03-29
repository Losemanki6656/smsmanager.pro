@extends('layouts.master')

@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 1)
            <div class="alert alert-success" id="success-alert">Succesfully!</div>
        @else
            <div class="alert alert-danger" id="success-alert2">Not Success!</div>
        @endif
    @endif

    <div class="col">
        <div class="card table-card">
            <div class="card-header">
                <form action="{{ route('numbers') }}" method="get">
                    @csrf
                    <div class="form-inline">
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="text" class="form-control" name="search" value="{{request('search')}}" id="search" placeholder="Поиск ...">
                        </div>
                        <button type="button" class="btn  btn-primary mb-2" data-toggle="modal"
                            data-target="#exampleModalCenter"><i class="fa fa-plus mr-2"></i>Добавить механик</button>
                    </div>
                </form>

                <div class="card-header-right">
                    <div class="btn-group card-option">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="feather icon-more-horizontal"></i>
                        </button>
                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item full-card"><a href="#!"><span><i
                                            class="feather icon-maximize"></i> maximize</span><span style="display:none"><i
                                            class="feather icon-minimize"></i> Restore</span></a></li>
                            <li class="dropdown-item minimize-card"><a href="#!"><span><i
                                            class="feather icon-minus"></i> collapse</span><span style="display:none"><i
                                            class="feather icon-plus"></i> expand</span></a></li>
                            <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i>
                                    reload</a></li>
                            <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-file-text"></i>
                                    Export</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <form action="{{ route('add_number') }}" method="post">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Добавить Механик</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="fullname" placeholder="ФИО"
                                        style="width: 100%;" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="staff_name" placeholder="Должность"
                                        style="width: 100%;" required>
                                </div>
                                <div class="form-group">
                                    <label for="organization_phone"> Тел</label>
                                    <input type="text" id="phone" class="form-control" name="phone" required
                                        placeholder="(+998) 99-000-00-00" value="+998" style="width: 100%;">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn  btn-secondary" data-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn  btn-primary"> Сохранить </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive">
                            <div id="rec-table">
                                @include('includes.include-numbers')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.getElementById('phone').addEventListener('input', function(e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
            e.target.value = '+(' + x[1] + ') ' + x[2] + '-' + x[3] + '-' + x[4] + '-' + x[5];
        });
    </script>

    <script>
        document.getElementById('phone2').addEventListener('input', function(e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
            e.target.value = '+(' + x[1] + ') ' + x[2] + '-' + x[3] + '-' + x[4] + '-' + x[5];
        });
    </script>

    <script type="text/javascript">
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
    </script>

    <script>
        function myFunction() {
            var checkBox = document.getElementById("customswitch1");
            var date_vacation = document.getElementById("date_vacation");

            if (checkBox.checked == true) {
                $("#date_vacation").prop('readonly', false);
            } else {
                $("#date_vacation").prop('readonly', true);
            }
        }
    </script>

@endsection
