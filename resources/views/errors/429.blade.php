@extends('errors.layout')

@section('code', '429')
@section('title', 'Too Many Requests')
@section('message', 'We noticed a lot of requests coming in at once, so we paused things briefly to keep the system responsive for everyone.')
@section('hint', 'Please wait a moment and try again. If you’re using automated tools, reduce the frequency of requests.')

