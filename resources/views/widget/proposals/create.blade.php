<form class="form-horizontal" action="{{ url('proposals') }}" method="post" id="create-proposal">
    {{ csrf_field() }}
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <div class="form-group row">
        <label class="col-sm-2 control-label">Price</label>
        <div class="col-sm-10">
            <input type="text" name="price" class="form-control" pattern="[0-9]{0,20}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 control-label">End date</label>
        <div class="col-sm-10">
            <input type="text" name="end_date" class="form-control" id="date-picker">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 control-label">Attachments</label>
        <div class="col-sm-10">
            <input type="file" name="attachments[]" multiple class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <button class="btn btn-primary">Propose</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $('#date-picker').datepicker()
        $('#create-proposal').submit(function(e) {
            $('#loading').fadeIn();
            e.preventDefault()
            var formData = new FormData($(this).get(0))
            formData.append('project_id', $('#project_id').val())
            $.ajax({
                url: '/proposals',
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    $('#modalWindow').modal('hide')
                    $('#proposal-list').load('/proposals/list/'+$('#project_id').val())
                },
                cache: false,
                contentType: false,
                processData: false,
                complete: function() {
                    $('#loading').fadeOut()
                }
            })
        })
    })
</script>
