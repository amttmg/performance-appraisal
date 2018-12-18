<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<table border="1">
  <thead>
  <tr>
    <th style="background-color: #e4edc6;" rowspan="2"><b>User Name</b></th>
    <th style="background-color: #e4edc6;" rowspan="2"><b>Type</b></th>
    @foreach($reports['headers']['groups'] as $group)
      <th colspan="{{ $group->questions->count() }}">{{ $group->title }}</th>
    @endforeach
  </tr>
  <tr>
    @foreach($reports['headers']['groups'] as $group)
      @foreach($group->questions->pluck('id') as $questionId)
        <th style="background-color: #e4edc6;">
          <b>{{ $questionId }}</b>
        </th>
      @endforeach
    @endforeach
  </tr>
  </thead>
  <tbody>
  @foreach($reports['body'] as $body)
    @foreach($reports['headers']['subHeaders'] as $typeId =>$subHeader)
      <tr>
        @if ($loop->first)
          <td rowspan="{{ count($reports['headers']['subHeaders']) }}">
            {{ $body->name }}
          </td>
        @endif
        <td>{{ $subHeader }}</td>
        @foreach($reports['headers']['groups'] as $groups)
          @foreach($groups->questions->pluck('id') as $questionId)
            @php($appraisal = $body->myAppraisal()->with(['answers'=>function($query) use ($questionId, $typeId){
         $query->where('question_id',$questionId);
         }])->whereHas('answers',function ($query) use ($questionId){
           $query->where('question_id',$questionId);
         })->where('type_id',$typeId)->first())
            @if (!empty($appraisal->answers[0]))
              <td>
                {{ $appraisal->answers[0]->rating }}
              </td>
            @else
              <td>-</td>
            @endif
          @endforeach
        @endforeach
      </tr>
    @endforeach
  @endforeach
  </tbody>
</table>
</html>