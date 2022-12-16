<?php

namespace App\Http\Controllers;

use App\Event;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Google\Service\Calendar as ServiceCalendar;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreEventRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreEventRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Event  $event
   * @return \Illuminate\Http\Response
   */
  public function show(Event $event)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Event  $event
   * @return \Illuminate\Http\Response
   */
  public function edit(Event $event)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateEventRequest  $request
   * @param  \App\Event  $event
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateEventRequest $request, Event $event)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Event  $event
   * @return \Illuminate\Http\Response
   */
  public function destroy(Event $event)
  {
    //
  }

  /**
   * Create a new event on a Google Calendar.
   *
   * @param Request $request
   * @return \Google_Service_Calendar_Event
   */
  public function createEvent(Event $event)
  {
    // Set up the Google API client
    $client = new Google_Client();
    $client->setApplicationName('Kota');
    $client->setAuthConfig(storage_path('app/google-calendar-api-key.json'));
    $client->setScopes(ServiceCalendar::CALENDAR);

    // Authenticate and authorize the client
    $service = new ServiceCalendar($client);

    // Create a new event
    $calendarEvent = new ServiceCalendar([
      'summary' => $event['title'],
      'start' => [
        'dateTime' => $event['start_time'],
        'timeZone' => 'Europe/Helsinki',
      ],
      'end' => [
        'dateTime' => $event['end_time'],
        'timeZone' => 'Europe/Helsinki',
      ],
      'description' => $event['description'],
      'location' => $event['location']
    ]);

    // Save the event to the calendar
    $calendarId = 'primary';
    $calendarEvent = $service->events->insert($calendarId, $calendarEvent);

    // Return the event details
    return $calendarEvent;
  }

  /**
   * Luodaan lippukunnan nettisivuille tapahtuma
   */
  public function createWebsiteEvent(Event $event)
  {
    $response = Http::withHeaders([
      'Content-Type' => 'application/json',
    ])->post(config('kota.websiteUrl') . '/wp-json/wp/v2/tapahtumat', [
      'title' => 'My Custom Post',
      'content' => '<p>This is the <strong>content</strong> of my custom post</p>',
      'status' => 'publish'
    ]);

    if ($response->successful()) {
      $post = $response->json();
      // The custom post was created successfully
    } else {
      // There was an error creating the custom post
    }
  }
}
