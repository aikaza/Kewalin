<table style="display: none !important;" id="row-cloned">
	<tbody>
		<tr>
			<td>
				<input type="text" name="p_color[]" class="form-control p-color rf" form="form">
				<span class="txt-p-color rlf hidden"></span>
			</td>
			<td>
				<input type="text" name="qtyp[]" class="form-control qtyp rf" form="form">
				<span class="txt-qtyp rlf hidden" ></span>
			</td>
			<td>
				<input type="text" class="form-control qtys rf" readonly style="cursor: pointer;" value="detail...">
				<input type="hidden" name="qtys[]" form="form">
				<span class="txt-qtys rlf hidden"></span>
			</td>
			<td style="width: 9%">
				<button class="btn btn-success save-btn btn-block" state="unsaved">
					<i class="fa fa-save"></i>
					&ensp;@lang('save')
				</button>
			</td>
			<td style="width: 9%">
				<button class="btn btn-danger del-btn btn-block">
					<i class="fa fa-trash"></i>
					&ensp;@lang('delete')
				</button>
			</td>
		</tr>
	</tbody>
</table>