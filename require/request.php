<!-- Content -->
<div class="card">
  <!-- Map interface -->
  <div id="map"></div>
  <div class="card-content activator" id="slider">
    <span class="card-title activator center-align teal-text lighten-1">Driver Location<i class="material-icons">keyboard_arrow_up</i></span>
  </div>
  <!-- Ride details interface -->
  <div class="card-reveal grey lighten-3">
    <span class="card-title center-align teal-text lighten-1" id="tabu">Ride Details<i class="material-icons">keyboard_arrow_down</i></span>
    <div class="container">
      <div class="row" style="margin-bottom: 16px;">
        <!-- Request Submission -->
        <div class="col s12 m8 offset-m2">
          <div class="card">
            <div class="card-content">
              <table>
                <colgroup>
                  <col width="0%">
                  <col width="100%">
                </colgroup>
                <tr>
                  <td class="grey-text">Driver</td>
                  <td class="data green-text" id="td1">-</td>
                </tr>
                <tr>
                  <td class="grey-text">Destination</td>
                  <td class="data green-text" id="td2">-</td>
                </tr>
                <tr>
                  <td class="grey-text">ETA</td>
                  <td class="data green-text" id="td3">-</td>
                </tr>
                <tr>
                  <td class="grey-text">Paid Passenger(s)</td>
                  <td class="data green-text" id="td4">-</td>
                </tr>
                <tr>
                  <td class="grey-text">Cost</td>
                  <td class="data green-text" id="td5">-</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  tr:first-child td {
    padding-top: 0;
  }

  tr:last-child td {
    padding-bottom: 0;
  }
</style>