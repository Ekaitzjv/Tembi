<tr>
    <td><a class="img-report" href="{{ route('image.detail', ['id' => $report->post->id])}}"><img
                src="{{ route('image.file',['filename' => $report->post->image_path]) }}" /></a></td>
    <td>{{ $report->post->user->name }} {{ $report->post->user->surname }}</td>
    <td>{{ $report->user->name }} {{ $report->user->surname }}</td>
    <td><a class="icons-report" href="{{route('ReportPostDelete', ['id' => $report->post->id])}}"><img src="{{asset('img/delete-post.png')}}"></a></td>
    <td><a class="icons-report" href="{{route('ReportUserDelete', ['id' => $report->post->user->id])}}"><img src="{{asset('img/delete-account.png')}}"></a></td>
    <td><a class="icons-report" href="{{route('ReportCancel', ['id' => $report->id])}}"><img src="{{asset('img/cancel.png')}}"></a></td>
</tr>