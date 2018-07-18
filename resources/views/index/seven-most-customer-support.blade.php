<div class="col-md-4 col-sm-4 col-xs-12">
  <div class="x_panel tile fixed_height_320" style="overflow: auto;">
    <div class="x_title">
      <h2>
        @lang('seven most supporter')
      </h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      @if ($data->isEmpty())
      <p>@lang('no content available')</p>
      @else
      <table>
        <tbody>
          @foreach ($data as $i => $ex)
          <tr>
            <td>
              <p>
                <a href="#">
                  <i class="fa fa-square {{ SevenMost::getRankColor($i+1) }}">
                  </i>
                  {{ $ex->customer->first_name }}
                  {{ $ex->customer->last_name }}
                </a>
              </p>
            </td>
            <td>
              <p class="{{ SevenMost::getRankColor($i+1) }}">
                {{ millionFormat($ex->qtyp,100000) }} 
              </p>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
</div>