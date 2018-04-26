<!-- Content -->
<div class="card" style="overflow: hidden;">
  <!-- Map interface -->
  <div id="map"></div>
  <div class="card-content activator" id="slider">
    <span class="card-title activator center-align teal-text lighten-1">Your Location<i class="material-icons">keyboard_arrow_up</i></span>
  </div>
  <!-- Ride details interface -->
  <div class="card-reveal grey lighten-3" style="display: block; transform: translateY(-100%);">
    <span class="card-title center-align teal-text lighten-1" id="tabu">Driver Dashboard<i class="material-icons">keyboard_arrow_down</i></span>
    <div class="container">
      <div class="row">
        <!-- Request Submission -->
        <div class="col s12 m8 offset-m2">

          <!-- Begin working mode -->
          <div class="card gutter hide" id="begin-working">
            <div class="card-content">
              <a class="btn waves-effect waves-light" id="begin-working-button" style="width: 100%;">Begin Working</a>

              <!-- Message -->
              <p>You must begin working to receive requests.</p>
            </div>
          </div>

          <!-- Stop working mode -->
          <div class="card gutter hide" id="stop-working">
            <div class="card-content">
              <a class="btn orange lighten-2 waves-effect waves-light" id="stop-working-button"  style="width: 100%;">Stop Working</a>

              <!-- Searching bar -->
              <div class="progress hide" id="searching">
                <div class="indeterminate"></div>
              </div>

              <!-- Capacity bar -->
              <div class="progress hide" id="capacity">
                <div class="determinate" id="capacity-bar" style="width: 0%"></div>
              </div>

              <!-- Message -->
              <p id="request-warning"></p>
            </div>
          </div>

          <!-- Hidden passenger details -->
          <div id="request-pane">
            <div class="card gutter hide" id="1">
              <div class="card-content">
                <table>
                  <colgroup>
                    <col width="0%">
                    <col width="100%">
                  </colgroup>
                  <tr>
                    <td class="grey-text">Rider</td>
                    <td class="data green-text" id="1-td1">-</td>
                  </tr>
                  <tr>
                    <td class="grey-text">Passenger(s)</td>
                    <td class="data green-text" id="1-td2">-</td>
                  </tr>
                  <tr>
                    <td class="grey-text">Payment</td>
                    <td class="data green-text" id="1-td3">-</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="card gutter hide" id="2">
              <div class="card-content">
                <table>
                  <colgroup>
                    <col width="0%">
                    <col width="100%">
                  </colgroup>
                  <tr>
                    <td class="grey-text">Rider</td>
                    <td class="data green-text" id="2-td1">-</td>
                  </tr>
                  <tr>
                    <td class="grey-text">Passenger(s)</td>
                    <td class="data green-text" id="2-td2">-</td>
                  </tr>
                  <tr>
                    <td class="grey-text">Payment</td>
                    <td class="data green-text" id="2-td3">-</td>
                  </tr>
                </table>
              </div>
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

  .gutter {
    margin-bottom: 16px;
  }

  p {
    margin-top: 8px !important;
    color: #9e9e9e !important;
  }
</style>