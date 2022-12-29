@if (count($cadry))
    <table class="table table-striped table-hover m-b-0">
        <thead>
            <tr>
                <th class="text-center" width="60"><span>№</span></th>
                <th class="text-center"><span>Наиминование Реле</span></th>
                <th class="text-center"><span>Пасспорт</span></th>
                <th class="text-center"><span>Статив</span></th>
                <th class="text-center"><span>Ряд</span></th>
                <th class="text-center"><span>Место</span></th>
                <th class="text-center"><span>Пред. Дата</span></th>
                <th class="text-center"><span>След. Дата</span></th>
                <th class="text-center"><span>Станция</span></th>
                <th class="text-center"><span>Тел</span></th>
                <th class="text-center" width="120"><span>Статус</span></th>
                <th class="text-center" width="260"><span>Действие</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cadry as $item)
                <tr>
                    <td class="text-center">{{ $loop->index + 1 }}</td>
                    <td class="text-center">{{ $item->fullname }}</td>
                    <td class="text-center">{{ $item->passport }}</td>
                    <td class="text-center">{{ $item->stativ }}</td>
                    <td class="text-center">{{ $item->rad }}</td>
                    <td class="text-center">{{ $item->mesto }}</td>
                    <td class="text-center">{{ $item->last_date->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $item->next_date->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $item->department->name ?? '' }}</td>
                    <td class="text-center">{{ $item->phone }}</td>
                    <td class="text-center">
                        @if ($item->next_date > now())
                            @if ($item->next_date->diffInDays() + 1 > 5)
                                <span class="badge badge-primary"> {{ $item->next_date->diffInDays() + 1 }} дней
                                    осталось </span>
                            @else
                                <span class="badge badge-warning"> {{ $item->next_date->diffInDays() + 1 }} дней
                                    осталось </span>
                            @endif
                        @else
                            <span class="badge badge-danger">Истек <span class="ms-1 fas fa-ban"
                                    data-fa-transform="shrink-2"></span></span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-icon btn-outline-success" title="Success"
                            data-toggle="modal" data-target="#succmodal{{ $item->id }}"><i
                                class="fa fa-check"></i></button>
                        <button type="button" class="btn btn-icon btn-outline-secondary" title="Edit"
                            data-toggle="modal" data-target="#editmodal{{ $item->id }}"><i
                                class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-icon btn-outline-danger" title="Delete"
                            data-toggle="modal" data-target="#deletemodal{{ $item->id }}"><i
                                class="fa fa-trash-alt"></i></button>
                        <button type="button" class="btn  btn-icon btn-outline-primary" title="Send Sms"
                            data-toggle="modal" data-target="#sendmodal{{ $item->id }}"><i
                                class="fa fa-paper-plane"></i></button>
                    </td>
                </tr>

                <div id="succmodal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <form action="{{ route('success_user') }}" method="get">
                        @csrf
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Реле</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="cadry_id" value="{{ $item->id }}">
                                        <input type="text" class="form-control" value="{{ $item->fullname }}"
                                            readonly style="width: 100%;" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="organization_phone">След. Дата</label>
                                        <input type="date" class="form-control" name="next_date"
                                            value="{{ $item->next_date->addYear()->format('Y-m-d') }}" required
                                            style="width: 100%;">
                                    </div>

                                    <div class="form-group">
                                        <label for="organization_phone">Комментария</label>
                                        <textarea name="comment" class="form-control" style="width: 100%;"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Отиена
                                    </button>
                                    <button type="submit" class="btn  btn-success"> Сохранить </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="editmodal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <form action="{{ route('edit_user') }}" method="get">
                        @csrf
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Редактировать реле</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="cadry_id" value="{{ $item->id }}">
                                        <label for="edtname">Наиминование Реле</label>
                                        <input type="text" class="form-control" name="fullname"
                                            value="{{ $item->fullname }}" style="width: 100%;" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="organization_phone">Станция</label>
                                        <select class="form-control" name="department_id" style="width: 100%;"
                                            required>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    @if ($item->department_id == $department->id) selected @endif>
                                                    {{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label>Пасспорт</label>
                                            <input type="text" class="form-control" name="passport"
                                                placeholder="Пасспорт" style="width: 100%;"
                                                value="{{ $item->passport }}" required>
                                        </div>
                                        <div class="col">
                                            <label>Статив</label>
                                            <input type="text" class="form-control" name="stativ"
                                                placeholder="Статив" style="width: 100%;"
                                                value="{{ $item->stativ }}" required>
                                        </div>

                                    </div>
                                    <div class="form-group row">

                                        <div class="col">
                                            <label>Ряд</label>
                                            <input type="text" class="form-control" name="rad"
                                                placeholder="Ряд" style="width: 100%;" value="{{ $item->rad }}"
                                                required>
                                        </div>
                                        <div class="col">
                                            <label>Место</label>
                                            <input type="text" class="form-control" name="mesto"
                                                placeholder="Место" style="width: 100%;" value="{{ $item->mesto }}"
                                                required>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="organization_phone"> Пред. Дата</label>
                                            <input type="date" class="form-control" name="last_date"
                                                value="{{ $item->last_date->format('Y-m-d') }}" required
                                                style="width: 100%;">
                                        </div>
                                        <div class="col">
                                            <label for="organization_phone"> След. Дата</label>
                                            <input type="date" class="form-control" name="next_date"
                                                value="{{ $item->next_date->format('Y-m-d') }}" required
                                                style="width: 100%;">
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary"
                                        data-dismiss="modal">Отиена</button>
                                    <button type="submit" class="btn  btn-success"> Сохранить </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="deletemodal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <form action="{{ route('delete_user') }}" method="get">
                        @csrf
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle"> Удалить Реле </h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="cadry_id" value="{{ $item->id }}">
                                        <h4><code> {{ $item->fullname }} </code></h4>
                                    </div>
                                    <div class="form-group">
                                        <h4>
                                            Вы действительно хотите удалить?
                                        </h4>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary"
                                        data-dismiss="modal"> Отиена</button>
                                    <button type="submit" class="btn  btn-danger"> Сохранить </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="sendmodal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <form action="{{ route('send_message') }}" method="get">
                        @csrf
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Отправить СМС</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="cadry_id" value="{{ $item->id }}">
                                        <input type="hidden" name="phone" value="{{ $item->phone }}">
                                        <h5><code> to:</code> {{ $item->fullname }}</h5>
                                    </div>
                                    <div class="form-group">
                                        <label for="textmessage">ТехТ</label>
                                        <textarea name="textmessage" class="form-control" id="textmessage" style="width: 100%" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary"
                                        data-dismiss="modal">Отиена</button>
                                    <button type="submit" class="btn  btn-success"> Отправить </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </tbody>
    </table>
@endif
