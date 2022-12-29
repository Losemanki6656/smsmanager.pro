@if (count($organizations))
    <table class="table table-striped table-hover m-b-0">
        <thead>
            <tr>
                <th width="60"><span>№</span></th>
                <th><span>Участка</span></th>
                <th><span>Количество Реле</span></th>
                <th class="text-center" width="380"><span>Действие</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($organizations as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->relays->count() }}</td>
                    <td>
                        <a href="/" type="button" class="btn btn-sm btn-icon btn-outline-primary"><i class="fa fa-eye"></i> Просмотр </a>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary" title="Edit" data-toggle="modal"
                            data-target="#editmodal{{ $item->id }}"><i class="fa fa-edit"></i> Редактировать</button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-danger" title="Delete"
                            data-toggle="modal" data-target="#deletemodal{{ $item->id }}"><i
                                class="fa fa-trash-alt"></i> Удалить</button>
                    </td>
                </tr>


                <div id="editmodal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <form action="{{ route('edit_organization') }}" method="get">
                        @csrf
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Редактировать участок</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="organization_id" value="{{ $item->id }}">
                                        <label for="edtname">Участка</label>
                                        <input type="text" class="form-control" id="editname" name="nameedit"
                                            value="{{ $item->fullname }}" style="width: 100%;" required>
                                    </div>
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary"
                                        data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn  btn-success"> Сохранить </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="deletemodal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <form action="{{ route('delete_number') }}" method="get">
                        @csrf
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle"> Удалить участок</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="organization_id" value="{{ $item->id }}">
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
                                        data-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn  btn-danger"> Удалить </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </tbody>
    </table>
@endif
