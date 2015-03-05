<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="./application/media/js/envision.min.css">

<script type="text/javascript" src="./application/media/js/envision.min.js"></script>

<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>

<title>TimeSeries</title>
</head>

<div id="demo" class="realtime">
	<div class="editor javascript">
		<div class="render" id="editor-render-0" data-node-uid="1">
        <font size="10">Underwater Environment Monitoring</font>
		</div>
    </div>
</div>

<script>
(function realtime_demo (container) {

  var
    x = [],
    dataA = [],
    dataB = [],
    data = [[x, dataA], [x, dataB]],
    options, i, timesries;

  // Mock Data:
  function sample(i) {
    x.push(i);
    dataA.push(Math.sin(i / 6) * (Math.random() + 1) / 2);
    dataB.push(Math.sin(i / 6 + Math.PI / 2) * (Math.random() + 1) / 2);
  }

  // Initial Data:
  for (i = 0; i < 100; i++) {
    sample(i);
  }

  // Envision Timeseries Options
  options = {
    container : container,
    data : {
      detail : data,
      summary : data
    },
    defaults : {
      summary : {
        config : {
          handles : { show : false }
        }
      }
    }
  }

  // Render the timeseries
  timeseries = new envision.templates.TimeSeries(options);

  // Method to get new data
  // This could be part of an Ajax callback, a websocket callback,
  // or streaming / long-polling data source.
  function getNewData () {
    i++;

    // Short circuit (no need to keep going!  you get the idea)
    if (i > 1000) return;

    sample(i);
    animate(i);
  }

  // Initial request for new data
  getNewData();

  // Animate the new data
  function animate (i) {

    var
      start = (new Date()).getTime(),
      length = 500, // 500ms animation length
      max = i - 1,  // One new point comes in at a time
      min = i - 51, // Show 50 in the top
      offset = 0;   // Animation frame offset

    // Render animation frame
    (function frame () {

      var
        time = (new Date()).getTime(),
        tick = Math.min(time - start, length),
        offset = (Math.sin(Math.PI * (tick) / length - Math.PI / 2) + 1) / 2;

      // Draw the summary first
      timeseries.summary.draw(null, {
        xaxis : {
          min : 0,
          max : max + offset
        }
      });

      // Trigger the select interaction.
      // Update the select region and draw the detail graph.
      timeseries.summary.trigger('select', {
        data : {
          x : {
            min : min + offset,
            max : max + offset
          }
        }
      });

      if (tick < length) {
        setTimeout(frame, 20);
      } else {
        // Pretend new data comes in every second
        setTimeout(getNewData, 500);
      }
    })();
  }
}
)(document.getElementById("editor-render-0"));
</script>

<body>
<div id="myfirstchart" style="height: 250px;"></div>
<script>
new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2008', value: 20 },
    { year: '2009', value: 10 },
    { year: '2010', value: 5 },
    { year: '2011', value: 5 },
    { year: '2012', value: 20 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});
</script>
</body>
</html>