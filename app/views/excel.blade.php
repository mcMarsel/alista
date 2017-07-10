@extends('master')
@section('content')
<form method="post" action="req" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" value="send">
    </form>
@stop