<?php
if ($_REQUEST['entity'] == "navBar") {
   ajaxResponse(getNavBarHtml('reload'));
   return;
}

$statusData = array(
    'system' => array(
      'permission' => 'System',
      'table' => 'Monitors',
      'limit' => 1,
      'elements' => array(
        'MonitorCount' => array( 'sql' => "count(*)" ),
        'ActiveMonitorCount' => array( 'sql' => "count(if(Function != 'None',1,NULL))" ),
        'State' => array( 'func' => "daemonCheck()?".translate('Running').":".translate('Stopped') ),
        'Load' => array( 'func' => "getLoad()" ),
        'Disk' => array( 'func' => "getDiskPercent()" ),
        ),
      ),
    'monitor' => array(
      'permission' => 'Monitors',
      'table' => 'Monitors',
      'limit' => 1,
      'selector' => "Monitors.Id",
      'elements' => array(
        'Id' => array( 'sql' => "Monitors.Id" ),
        'Name' => array( 'sql' => "Monitors.Name" ),
        'Type' => true,
        'Function' => true,
        'Enabled' => true,
        'LinkedMonitors' => true,
        'Triggers' => true,
        'Device' => true,
        'Channel' => true,
        'Format' => true,
        'Host' => true,
        'Port' => true,
        'Path' => true,
        'Width' => array( 'sql' => "Monitors.Width" ),
        'Height' => array( 'sql' => "Monitors.Height" ),
        'Palette' => true,
        'Orientation' => true,
        'Brightness' => true,
        'Contrast' => true,
        'Hue' => true,
        'Colour' => true,
        'EventPrefix' => true,
        'LabelFormat' => true,
        'LabelX' => true,
        'LabelY' => true,
        'LabelSize' => true,
        'ImageBufferCount' => true,
        'WarmupCount' => true,
        'PreEventCount' => true,
        'PostEventCount' => true,
        'AlarmFrameCount' => true,
        'SectionLength' => true,
        'FrameSkip' => true,
        'MotionFrameSkip' => true,
        'MaxFPS' => true,
        'AlarmMaxFPS' => true,
        'FPSReportInterval' => true,
        'RefBlendPerc' => true,
        'Controllable' => true,
        'ControlId' => true,
        'ControlDevice' => true,
        'ControlAddress' => true,
        'AutoStopTimeout' => true,
        'TrackMotion' => true,
        'TrackDelay' => true,
        'ReturnLocation' => true,
        'ReturnDelay' => true,
        'DefaultView' => true,
        'DefaultRate' => true,
        'DefaultScale' => true,
        'WebColour' => true,
        'Sequence' => true,
        'MinEventId' => array( 'sql' => "(SELECT min(Events.Id) FROM Events WHERE Events.MonitorId = Monitors.Id" ),
        'MaxEventId' => array( 'sql' => "(SELECT max(Events.Id) FROM Events WHERE Events.MonitorId = Monitors.Id" ),
        'TotalEvents' => array( 'sql' => "(SELECT count(Events.Id) FROM Events WHERE Events.MonitorId = Monitors.Id" ),
        'Status' => array( 'zmu' => "-m ".escapeshellarg($_REQUEST['id'][0])." -s" ),
        'FrameRate' => array( 'zmu' => "-m ".escapeshellarg($_REQUEST['id'][0])." -f" ),
        ),
      ),
      'events' => array(
            'permission' => 'Events',
            'table' => 'Events',
            'selector' => "Events.MonitorId",
            'elements' => array(
              'Id' => true,
              'Name' => true,
              'Cause' => true,
              'Notes' => true,
              'StartTime' => true,
              'StartTimeShort' => array( 'sql' => "date_format( StartTime, '".MYSQL_FMT_DATETIME_SHORT."' )" ), 
              'EndTime' => true,
              'Width' => true,
              'Height' => true,
              'Length' => true,
              'Frames' => true,
              'AlarmFrames' => true,
              'TotScore' => true,
              'AvgScore' => true,
              'MaxScore' => true,
              ),
            ),
            'event' => array(
                'permission' => 'Events',
                'table' => 'Events',
                'limit' => 1,
                'selector' => "Events.Id",
                'elements' => array(
                  'Id' => array( 'sql' => "Events.Id" ),
                  'MonitorId' => true,
                  'MonitorName' => array('sql' => "(SELECT Monitors.Name FROM Monitors WHERE Monitors.Id = Events.MonitorId)"),
                  'Name' => true,
                  'Cause' => true,
                  'StartTime' => true,
                  'StartTimeShort' => array( 'sql' => "date_format( StartTime, '".MYSQL_FMT_DATETIME_SHORT."' )" ), 
                  'EndTime' => true,
                  'Width' => true,
                  'Height' => true,
                  'Length' => true,
                  'Frames' => true,
                  'DefaultVideo' => true,
                  'AlarmFrames' => true,
                  'TotScore' => true,
                  'AvgScore' => true,
                  'MaxScore' => true,
                  'Archived' => true,
                  'Videoed' => true,
                  'Uploaded' => true,
                  'Emailed' => true,
                  'Messaged' => true,
                  'Executed' => true,
                  'Notes' => true,
                  'MinFrameId' => array( 'sql' => "(SELECT min(Frames.FrameId) FROM Frames WHERE EventId=Events.Id)" ),
                  'MaxFrameId' => array( 'sql' => "(SELECT max(Frames.FrameId) FROM Frames WHERE Events.Id = Frames.EventId)" ),
                  'MinFrameDelta' => array( 'sql' => "(SELECT min(Frames.Delta) FROM Frames WHERE Events.Id = Frames.EventId)" ),
                  'MaxFrameDelta' => array( 'sql' => "(SELECT max(Frames.Delta) FROM Frames WHERE Events.Id = Frames.EventId)" ),
                  //'Path' => array( 'postFunc' => 'getEventPath' ),
                  ),
                  ),
                  'frames' => array(
                      'permission' => 'Events',
                      'table' => 'Frames',
                      'selector' => 'EventId',
                      'elements' => array(
                        'EventId' => true,
                        'FrameId' => true,
                        'Type' => true,
                        'Delta' => true,
                      ),
                  ),
                  'frame' => array(
                      'permission' => 'Events',
                      'table' => 'Frames',
                      'limit' => 1,
                      'selector' => array( array( 'table' => 'Events', 'join' => "Events.Id = Frames.EventId", 'selector'=>"Events.Id" ), "Frames.FrameId" ),
                      'elements' => array(
                        //'Id' => array( 'sql' => "Frames.FrameId" ),
                        'FrameId' => true,
                        'EventId' => true,
                        'Type' => true,
                        'TimeStamp' => true,
                        'TimeStampShort' => array( 'sql' => "date_format( StartTime, '".MYSQL_FMT_DATETIME_SHORT."' )" ), 
                        'Delta' => true,
                        'Score' => true,
                        //'Image' => array( 'postFunc' => 'getFrameImage' ),
                        ),
                      ),
                  'frameimage' => array(
                      'permission' => 'Events',
                      'func' => "getFrameImage()"
                      ),
                  'nearframe' => array(
                      'permission' => 'Events',
                      'func' => "getNearFrame()"
                      ),
                  'nearevents' => array(
                      'permission' => 'Events',
                      'func' => "getNearEvents()"
                      )
                  );

function collectData() {
  global $statusData;

  $entitySpec = &$statusData[strtolower(validJsStr($_REQUEST['entity']))];
#print_r( $entitySpec );
  if ( !canView( $entitySpec['permission'] ) )
    ajaxError( 'Unrecognised action or insufficient permissions' );

  if ( !empty($entitySpec['func']) ) {
    $data = eval( "return( ".$entitySpec['func']." );" );
  } else {
    $data = array();
    $postFuncs = array();

    $fieldSql = array();
    $joinSql = array();
    $groupSql = array();

    $elements = &$entitySpec['elements'];
    $lc_elements = array_change_key_case( $elements );

    $id = false;
    if ( isset($_REQUEST['id']) )
      if ( !is_array($_REQUEST['id']) )
        $id = array( validJsStr($_REQUEST['id']) );
      else
        $id = array_values( $_REQUEST['id'] );

    if ( !isset($_REQUEST['element']) )
      $_REQUEST['element'] = array_keys( $elements );
    else if ( !is_array($_REQUEST['element']) )
      $_REQUEST['element'] = array( validJsStr($_REQUEST['element']) );

    if ( isset($entitySpec['selector']) ) {
      if ( !is_array($entitySpec['selector']) )
        $entitySpec['selector'] = array( $entitySpec['selector'] );
      foreach( $entitySpec['selector'] as $selector )
        if ( is_array( $selector ) && isset($selector['table']) && isset($selector['join']) )
          $joinSql[] = "left join ".$selector['table']." on ".$selector['join'];
    }

    foreach ( $_REQUEST['element'] as $element ) {
      if ( !($elementData = $lc_elements[strtolower($element)]) )
        ajaxError( "Bad ".validJsStr($_REQUEST['entity'])." element ".$element );
      if ( isset($elementData['func']) )
        $data[$element] = eval( "return( ".$elementData['func']." );" );
      else if ( isset($elementData['postFunc']) )
        $postFuncs[$element] = $elementData['postFunc'];
      else if ( isset($elementData['zmu']) )
        $data[$element] = exec( escapeshellcmd( getZmuCommand( " ".$elementData['zmu'] ) ) );
      else {
        if ( isset($elementData['sql']) )
          $fieldSql[] = $elementData['sql']." as ".$element;
        else
          $fieldSql[] = $element;
        if ( isset($elementData['table']) && isset($elementData['join']) ) {
          $joinSql[] = "left join ".$elementData['table']." on ".$elementData['join'];
        }
        if ( isset($elementData['group']) ) {
          $groupSql[] = $elementData['group'];
        }
      }
    }

    if ( count($fieldSql) ) {
      $sql = "select ".join( ", ", $fieldSql )." from ".$entitySpec['table'];
      if ( $joinSql )
        $sql .= " ".join( " ", array_unique( $joinSql ) );
      if ( $id && !empty($entitySpec['selector']) ) {
        $index = 0;
        $where = array();
        $values = array();
        foreach( $entitySpec['selector'] as $selector ) {
          if ( is_array( $selector ) ) {
            $where[] = $selector['selector'].' = ?';
            $values[] = validInt($id[$index]);
          } else {
            $where[] = $selector.' = ?';
            $values[] = validInt($id[$index]);
          }
          $index++;
        }
        $sql .= " where ".join( " and ", $where );
      }
      if ( $groupSql )
        $sql .= " GROUP BY ".join( ",", array_unique( $groupSql ) );
      if ( !empty($_REQUEST['sort']) )
        $sql .= " order by ".$_REQUEST['sort'];
      if ( !empty($entitySpec['limit']) )
        $limit = $entitySpec['limit'];
      elseif ( !empty($_REQUEST['count']) )
        $limit = validInt($_REQUEST['count']);
      $limit_offset="";
      if ( !empty($_REQUEST['offset']) )
        $limit_offset = validInt($_REQUEST['offset']) . ", ";
      if ( !empty( $limit ) )
        $sql .= " limit ".$limit_offset.$limit;
      if ( isset($limit) && $limit == 1 ) {
        if ( $sqlData = dbFetchOne( $sql, NULL, $values ) ) {
          foreach ( $postFuncs as $element=>$func )
            $sqlData[$element] = eval( 'return( '.$func.'( $sqlData ) );' );
          $data = array_merge( $data, $sqlData );
        }
      } else {
        $count = 0;
        foreach( dbFetchAll( $sql, NULL, $values ) as $sqlData ) {
          foreach ( $postFuncs as $element=>$func )
            $sqlData[$element] = eval( 'return( '.$func.'( $sqlData ) );' );
          $data[] = $sqlData;
          if ( isset($limi) && ++$count >= $limit )
            break;
        }
      }
    }
  }
#print_r( $data );
  return( $data );
}

$data = collectData();

if ( !isset($_REQUEST['layout']) ) {
  $_REQUEST['layout'] = 'json';
}

switch( $_REQUEST['layout'] ) {
  case 'xml NOT CURRENTLY SUPPORTED' :
    {
      header("Content-type: application/xml" );
      echo( '<?xml version="1.0" encoding="iso-8859-1"?>'."\n" );
      echo "<".strtolower($_REQUEST['entity']).">\n";
      foreach ( $data as $key=>$value ) {
        $key = strtolower( $key );
        echo "<$key>".htmlentities($value)."</$key>\n";
      }
      echo "</".strtolower($_REQUEST['entity']).">\n";
      break;
    }
  case 'json' :
    {
      $response = array( strtolower(validJsStr($_REQUEST['entity'])) => $data );
      if ( isset($_REQUEST['loopback']) )
        $response['loopback'] = validJsStr($_REQUEST['loopback']);
      ajaxResponse( $response );
      break;
    }
  case 'text' :
    {
      header("Content-type: text/plain" );
      echo join( " ", array_values( $data ) );
      break;
    }
}

function getFrameImage() {
  $eventId = $_REQUEST['id'][0];
  $frameId = $_REQUEST['id'][1];

  $sql = 'select * from Frames where EventId = ? and FrameId = ?';
  if ( !($frame = dbFetchOne( $sql, NULL, array( $eventId, $frameId ) )) ) {
    $frame = array();
    $frame['EventId'] = $eventId;
    $frame['FrameId'] = $frameId;
    $frame['Type'] = 'Virtual';
  }
  $event = dbFetchOne( 'select * from Events where Id = ?', NULL, array( $frame['EventId'] ) );
  $frame['Image'] = getImageSrc( $event, $frame, SCALE_BASE );
  return( $frame );
}

function getNearFrame() {
  $eventId = $_REQUEST['id'][0];
  $frameId = $_REQUEST['id'][1];

  $sql = 'select FrameId from Frames where EventId = ? and FrameId <= ? order by FrameId desc limit 1';
  if ( !$nearFrameId = dbFetchOne( $sql, 'FrameId', array( $eventId, $frameId ) ) ) {
    $sql = 'select * from Frames where EventId = ? and FrameId > ? order by FrameId asc limit 1';
    if ( !$nearFrameId = dbFetchOne( $sql, 'FrameId', array( $eventId, $frameId ) ) ) {
      return( array() );
    }
  }
  $_REQUEST['entity'] = 'frame';
  $_REQUEST['id'][1] = $nearFrameId;
  return( collectData() );
}

function getNearEvents() {
  global $user, $sortColumn, $sortOrder;

  $eventId = $_REQUEST['id'];
  $event = dbFetchOne( 'SELECT * FROM Events WHERE Id=?', NULL, array( $eventId ) );

  if ( isset($_REQUEST['filter']) )
    parseFilter( $_REQUEST['filter'] );
  parseSort();

  if ( $user['MonitorIds'] )
    $midSql = " and MonitorId in (".join( ",", preg_split( '/["\'\s]*,["\'\s]*/', $user['MonitorIds'] ) ).")";
  else
    $midSql = '';

  $sql = "SELECT E.Id AS Id, E.StartTime AS StartTime FROM Events AS E INNER JOIN Monitors AS M ON E.MonitorId = M.Id WHERE $sortColumn ".($sortOrder=='asc'?'<=':'>=')." '".$event[$_REQUEST['sort_field']]."'".$_REQUEST['filter']['sql'].$midSql." ORDER BY $sortColumn ".($sortOrder=='asc'?'desc':'asc') . ' LIMIT 2';
  $result = dbQuery( $sql );
  while ( $id = dbFetchNext( $result, 'Id' ) ) {
    if ( $id == $eventId ) {
      $prevEvent = dbFetchNext( $result );
      break;
    }
  }

  $sql = "SELECT E.Id AS Id, E.StartTime AS StartTime FROM Events AS E INNER JOIN Monitors AS M ON E.MonitorId = M.Id WHERE $sortColumn ".($sortOrder=='asc'?'>=':'<=')." '".$event[$_REQUEST['sort_field']]."'".$_REQUEST['filter']['sql'].$midSql." ORDER BY $sortColumn $sortOrder LIMIT 2";
  $result = dbQuery( $sql );
  while ( $id = dbFetchNext( $result, 'Id' ) ) {
    if ( $id == $eventId ) {
      $nextEvent = dbFetchNext( $result );
      break;
    }
  }

  $result = array( 'EventId'=>$eventId );
  $result['PrevEventId'] = empty($prevEvent)?0:$prevEvent['Id'];
  $result['NextEventId'] = empty($nextEvent)?0:$nextEvent['Id'];
  $result['PrevEventStartTime'] = empty($prevEvent)?0:$prevEvent['StartTime'];
  $result['NextEventStartTime'] = empty($nextEvent)?0:$nextEvent['StartTime'];
  $result['PrevEventDefVideoPath'] = empty($prevEvent)?0:(getEventDefaultVideoPath($prevEvent['Id']));
  $result['NextEventDefVideoPath'] = empty($nextEvent)?0:(getEventDefaultVideoPath($nextEvent['Id']));
  return( $result );
}

?>
