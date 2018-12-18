<html xmlns:x="urn:schemas-microsoft-com:office:excel">
@if($reports->count()>0)
  <table>
    <thead>
    <tr>
      @foreach($reports->first()->toArray() as $key=>$header)
        <th>{{$key}}</th>
      @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($reports as $report)
      <tr>
        @foreach($report->toArray() as $value)
          <td>{{ $value }}</td>
        @endforeach
      </tr>
    @endforeach
    </tbody>
  </table>
@endif
</html>