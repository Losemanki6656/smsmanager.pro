@if (count($comments))  
    <table class="table table-striped table-hover m-b-0">
        <thead>
            <tr>
                <th><span>№</span></th>
                <th><span>Name</span></th>
                <th><span>Text Message</span></th>
                <th><span>Status</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comments as $item)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>
                        @if($item->cadry)
                        {{$item->cadry->fullname}}
                        @endif
                    </td>
                    <td >{{$item->comment}}</td>
                    <td>
                        <span class="badge badge-success text-dark">    {{$item->created_at->format('d-m-Y , H:i:s')}} </span>
                    </td>
                </tr>
                

            @endforeach
        </tbody>
    </table>
@endif