<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
    <tbody>
        @foreach ($enquiry as $key => $value)
            <tr>
                <th align="left" width="25%" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px; font-weight: bold;">
                    {{ str_replace('_', ' ', $key) }}
                </th>

                <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                    {!! nl2br($value) !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
