<?php
//header('HTTP/1.1 422 Unprocessable Entity');
header('Content-Type: application/json; charset=UTF-8');
  $resp = '
  "draw": 4,
  "recordsTotal": 57,
  "recordsFiltered": 57,
  "data":[
    {
       "name": "John",
       "position": "Product Manager",
       "office": "San Francisco",
       "salary": 142557,
       "address": "54,komal street"
    },
    {
       "name": "Bob",
       "position": "Data Analyst",
       "office": "Tokyo",
       "salary": 103692,
       "address": "54,komal street"
    },
    {
       "name": "Alice",
       "position": "Marketing Manager",
       "office": "San Francisco",
       "salary": 109669,
       "address": "54,komal street"
    },
    {
       "name": "Steve",
       "position": "Data Analyst",
       "office": "New York",
       "salary": 130649,
       "address": "54,komal street"
    },
    {
       "name": "Bob",
       "position": "Software Engineer",
       "office": "Paris",
       "salary": 106573,
       "address": "54,komal street"
    }
 ]';
 $resp = '[
    {
       "name": "John",
       "position": "Product Manager",
       "office": "San Francisco",
       "salary": 142557
    },
    {
       "name": "Bob",
       "position": "Data Analyst",
       "office": "Tokyo",
       "salary": 103692
    },
    {
       "name": "Alice",
       "position": "Marketing Manager",
       "office": "San Francisco",
       "salary": 109669
    },
    {
       "name": "Steve",
       "position": "Data Analyst",
       "office": "New York",
       "salary": 130649
    },
    {
       "name": "Bob",
       "position": "Software Engineer",
       "office": "Paris",
       "salary": 106573
    }
 ]';
$resp = json_decode($resp,false);
echo json_encode($resp);
