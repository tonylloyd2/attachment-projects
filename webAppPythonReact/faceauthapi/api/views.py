from django.shortcuts import render
from django.http import HttpResponse
# Create your views here.
# end points , location on the web server

def main(request):
    return HttpResponse("Hello world")