<!-- Modal New Attendance -->

<div id="modalNewAttendance" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4 class="titleB01">New Attendance</h4>
    <hr class="mb20">
    <div class="row">

      <!-- Kiri -->
      <div class="col l6">
        <div class="row mt0">
          <!-- Row 1 -->
          <div class="col mt0 l12 input-field">
            <input type="radio" class="with-gap" id="singleRow">
            <label for="singleRow">Single Row</label>
          </div>
          <div class="col mt0 l12 input-field">
            <input type="radio" class="with-gap" id="multipleRow">
            <label for="multipleRow">Multiple Row</label>
          </div>
          <div class="col mt0 l12 input-field">
            <input type="checkbox" class="filled-in" id="headerRow">
            <label for="headerRow">With header row</label>
          </div>

          <!-- Row 2 -->
          <div class="col l12 input-field">
            <input type="text" id="settingAttendanceName">
            <label for="settingAttendanceName">Setting Name</label>
          </div>

          <!-- Row 3 -->
          <div class="col l6 input-field">
            <select>
              <option>--Selet File Type--</option>
              <option>CSV</option>
              <option>DAT</option>
            </select>
            <label>File Type</label>
          </div>
          <div class="col l6 input-field">
            <select>
              <option>--Selet Delimiter--</option>
              <option>Comma (,)</option>
              <option>Dot (,)</option>
            </select>
            <label>File Type</label>
          </div>

          <!-- Row 4 -->
          <div class="col l6 input-field">
            <input type="text" id="barcode">
            <label for="barcode">Barcode</label>
          </div>
          <div class="col l6 input-field">
            <input type="text" id="barcodeLength">
            <label for="barcodeLength">Barcode Length</label>
          </div>

          <!-- Row 5 -->
          <div class="col l6 input-field">
            <input type="text" id="CheckIn">
            <label for="CheckIn">Check In</label>
          </div>
          <div class="col l6 input-field">
            <input type="text" id="CheckInLength">
            <label for="CheckInLength">Check In Length</label>
          </div>

          <!-- Row 6 -->
          <div class="col l6 input-field">
            <input type="text" id="CheckOut">
            <label for="CheckOut">Check Out</label>
          </div>
          <div class="col l6 input-field">
            <input type="text" id="CheckOutLength">
            <label for="CheckOutLength">Check Out Length</label>
          </div>

      </div>
      </div>

      <!-- Kanan -->
      <div class="col l6">
        <div class="row">
          <!-- Row 1 -->
          <div class="col l6 input-field">
            <input type="text" id="date">
            <label for="date">Date</label>
          </div>
          <div class="col l6 input-field">
            <input type="text" id="dateLength">
            <label for="dateLength">Date Length</label>
          </div>

          <!-- Row 2 -->
          <div class="col l6 input-field">
            <select>
              <option>--Selet Date Type--</option>
              <option>Y-M-D</option>
              <option>Y-M-D</option>
            </select>
            <label>Date Format</label>
          </div>
          <div class="col l6 input-field">
            <select>
              <option>--Selet Time Type--</option>
              <option>H:M:s (24)</option>
              <option>H:M:s (12)</option>
            </select>
            <label>Time FOrmat</label>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close btn btnB01">Close</a>
    <a href="#!" class="modal-action modal-close btn btnB01 mr5">Save</a>
  </div>
</div>
