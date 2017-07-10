@extends('master')

@section('content')

<table>
	<tr>
		<td>{{ $clientName }}</td>
	</tr>
	<tr>
		<td>{{ $region }}</td>
	</tr>
	<tr>
		<td>{{ $city }}</td>
	</tr>
	<tr>
		<td>{{ $fullName }}</td>
	</tr>
	<tr>
		<td>{{ $timeWork }}</td>
	</tr>
	<tr>
		<td>{{ $phone }}</td>
	</tr>
</table>

@stop