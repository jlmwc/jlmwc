<?php
echo '{"type": "FeatureCollection","features":';
echo json_encode($map, JSON_PRETTY_PRINT);
echo '}';


/* End of file geojson.php */
/* Location: ./application/views/geojson.php */
