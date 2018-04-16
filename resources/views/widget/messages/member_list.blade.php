<table class="table">
    @foreach ($room->creativeroomUsers as $creativeroomUser)
        <tr>
            <td>{{ $creativeroomUser->user->email }}</td>
            <td>{{ $creativeroomUser->role }}</td>
            <td>
                <a class="remove-member" href="{{ url('/remove-user/'.$creativeroomUser->id) }}">
                    <button type="button" class="btn btn-default">Delete</button>
                </a>
            </td>
        </tr>
    @endforeach
</table>
<script type="text/javascript">
    $('.remove-member').click(function(e) {
        e.preventDefault()
        var link = $(this)
        $.get(link.attr('href'), function(response) {
            $('.member-list').html(response)
        } )
    })
</script>
