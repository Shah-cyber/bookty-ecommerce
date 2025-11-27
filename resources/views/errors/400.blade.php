@extends('errors.layout')

@section('code', '400')
@section('title', 'Bad Request')
@section('message', 'We couldn’t understand the request that was sent. This usually happens when a form field contains unexpected data or the browser cached an outdated version of the page.')
@section('hint', 'Please refresh the page, double-check the information you entered, and try again.')

