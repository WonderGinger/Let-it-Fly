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
          <!-- Toggles -->
          <div class="card gutter">
            <div class="card-content">
              <a class="btn waves-effect waves-light" style="width: 100%;">Begin Working</a>
              <p>You must begin working to receive requests.</p>
              <div class="progress hide" id="searching">
                <div class="indeterminate"></div>
              </div>
              <div class="progress hide" id="capacity">
                <div class="determinate" style="width: 50%"></div>
              </div>
            </div>
          </div>

          
          
          

          <div class="card gutter hide">
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


<!--

          <div class="card gutter hide">
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

          
          
          
          
          
          
          
          
          
          
-->

<!-- One of the two ways of doing map display logic
<div class="container">
    <p id="debug"></p>
    <div class="section teal-text lighten-1 center-align">
        <div class="row">
            <a id="working-toggle" class="col s12 waves-effect green lighten-1 waves-light btn-large">START</a>
        </div>
        <div class="row">
            <div class="progress" id="progress" style="visibility: hidden"><div class="determinate" id="preload"></div></div>  
        </div>
        <div class="row">
            <p id="waiting-message"></p>
        </div>
    </div>
</div>
<div id="map"></div>
.-->




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