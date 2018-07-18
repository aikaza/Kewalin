<div class="col-md-4 col-sm-4 col-xs-12">
  <div class="x_panel tile fixed_height_320"  class="x_content" style="overflow: auto;">
    <div class="x_title">
      <h2>
        @lang('seven most importing')
      </h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
      @if ($data->isEmpty())
      <p>
        @lang('no content available')
      </p>
      @else
      <table>
        <tbody>
          @foreach ($data as $i => $im)
          <tr>
            <td>
              <p>
                <a href="{{ route('stocks.detail',$im->product_id) }}">
                  <i class="fa fa-square {{ SevenMost::getRankColor($i+1) }}">
                  </i>
                  {{ $im->product->code }} /
                  {{ $im->product_color}}
                  {{ $im->product->name }}
                </a>
              </p>
            </td>
            <td>
              <p class="{{ SevenMost::getRankColor($i+1) }}" data-toggle="tooltip" title="{{ number_format($im->qtyp) }}">
                {{ millionFormat($im->qtyp,100000) }} 
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