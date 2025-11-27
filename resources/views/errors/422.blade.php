@extends('errors.layout')

@section('code', '422')
@section('title', 'Validation Failed')
@section('message', 'Some of the information you submitted does not pass validation. This can happen when required fields are missing or values are outside the allowed range.')
@section('hint', 'Scroll back to the form, review the highlighted fields, and update the information before submitting again.')

