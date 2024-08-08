let map;
let marker;
let myLatLng = { lat:24.1411346 , lng:50.3550914 };
async function initMap() {
  const { Map } = await google.maps.importLibrary("maps");
  myLatLng = { lat: 24.1411346, lng: 50.3550914 };
  map = new Map(document.getElementById("map"), {
      center: { lat: -34.397, lng: 150.644 },
      zoom: 8,
  });
  map.setCenter( myLatLng);
  marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
});
}
initMap();
function updatePosition(newLat,newLng)
{
    const latLng = { lat: parseFloat(newLat), lng: parseFloat(newLng)};

    marker.setPosition(latLng);
    map.setCenter(latLng);
    
   
}
let n=0;
window.Echo.channel('location')
            .listen('SendLocation' , (e)=>{
                n++;
                updatePosition(e.location['lat'],e.location['long'])}
            )