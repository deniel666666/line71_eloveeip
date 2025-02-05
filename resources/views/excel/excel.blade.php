<table>
    @if(count($head)>0)
    <thead>
        <tr>
            @foreach($head as $key => $vo)
            <th>{{$vo}}</th>
            @endforeach
        </tr>
    </thead>
    @endif

    <tbody>
    @foreach($data as $key_data => $vo_data)
        <tr>
            @if(count($head)>0)
                @foreach($head as $key => $vo)
                    <td>{{ $data[$key_data][$key] }}</td>
                @endforeach
            @else
                @foreach($vo_data as $vo)
                    <td>{{ $vo }}</td>
                @endforeach
            @endif
        </tr>
    @endforeach
    </tbody>
</table>