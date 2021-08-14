<form action="{{ asset('admin/store') }}" method="post">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">批量生成激活码</h3>
                </div>
                <div class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group  {!! !$errors->has('number') ? '' : 'has-error' !!}">
                            <label for="text1" class="col-sm-2 control-label">生成个数</label>
                            <div class="col-sm-10">
                                @foreach ($errors->get('number') as $error)
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$error}}</label><br />
                                @endforeach
                                <input type="number" class="form-control" id="text1" placeholder="生成个数" name="number">
                            </div>
                        </div>

                        <div class="form-group  {!! !$errors->has('integral') ? '' : 'has-error' !!}">
                            <label for="text2" class="col-sm-2 control-label">积分</label>
                            <div class="col-sm-10">
                                @foreach ($errors->get('name') as $error)
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$error}}</label><br />
                                @endforeach
                                <input type="number" class="form-control" id="text2" placeholder="积分" name="integral">
                            </div>
                        </div>

                        <div class="form-group  {!! !$errors->has('valid_period') ? '' : 'has-error' !!}">
                            <label for="text3" class="col-sm-2 control-label">有效期</label>
                            <div class="col-sm-10">
                                @foreach ($errors->get('valid_period') as $error)
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{$error}}</label><br />
                                @endforeach
                                <input type="date" class="form-control" id="text3" placeholder="有效期" name="valid_period">
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="box-footer">
        <button type="submit" class="btn btn-info pull-right">保存</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>
</form>