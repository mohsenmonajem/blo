<html>
<head>
        <script src="{{ asset('js-persian-cal.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('js-persian-cal.css') }}">
</head>
<body>
  <form method="post" action={{ url("/teacher/saveclass")}}>
        <span>   تاریخ شروع کلاس </span>
       <input type="text" id="pcal1" class="pdate" name="startdate" {{ old('startdate') }}>
         <small class="text-danger">{{ $errors->first('startdate') }}</small>
                {{ csrf_field() }}
       <br>
          <span>   تاریخ پایان کلاس</span>
             <input type="text" id="pcal2" class="pdate" name="enddate" value={{ old('enddate') }}>
                      <small class="text-danger">{{ $errors->first('enddate') }}</small>
        <br>
        <span>  ظرفیت کلاس </span>
        <input type="number"  name="capacity" value={{ old('capacity') }}>
         <small class="text-danger">{{ $errors->first('capacity') }}</small>
        <br>
        <span>  ادرس</sapn>
        <input type="text" name="address" value={{ old('address') }}>
                 <small class="text-danger">{{ $errors->first('address') }}</small>

        <br>
         @foreach($lessondetail as $value)
         <span> {{ $value->namelesson }} {{ $value->payenumber}}  </span>
         <input type="radio" name="dars" value="{{ $value->id }}">
         <br>
         @endforeach
        <br>
                       <small class="text-danger">{{ $errors->first('cost') }}</small>
                       <input type="number" name="cost"><span> قیمت تومان </span>
<br>
<input type="submit" value="ارسال">
<span class="text-danger">{{ $errors->first('dars') }}</span>
</form>
<script>
	var objCal1 = new AMIB.persianCalendar( 'pcal1',
		{ extraInputID: "extra", extraInputFormat: "YYYYMMDD" }
	);
        var objCal2 = new AMIB.persianCalendar( 'pcal2',
		{ extraInputID: "extra2", extraInputFormat: "YYYYMMDD" }
	);
</script>
</body>
</html>
