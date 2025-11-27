@extends('errors.layout')

@section('code', '401')
@section('title', 'Unauthorized')
@section('message', 'You need to be signed in to access this page or resource. Your session may have expired or you tried to open a secure page without logging in.')
@section('hint', 'Please sign in again to continue. If the problem persists, clear your browser cookies and try once more.')

