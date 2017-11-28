<div class="col-md-6">
    <div class="profilepic"><img class="profilepicsize" src="../{{ $contact->avatar }}" /></div>

    <h1 class="moveup">{{$athlete->name}}</h1>

    <!--Athlete info leftside-->
    <div class="contactleft">
        @if($athlete->email != "")
                <!--MAIL-->
        <p><span class="glyphicon glyphicon-envelope" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('mail') }}" data-placement="left"> </span>
            <a href="mailto:{{$athlete->email}}" data-toggle="tooltip" data-placement="left">{{$athlete->email}}</a></p>
        @endif
        @if($athlete->primary_number != "")
                <!--Work Phone-->
        <p><span class="glyphicon glyphicon-phone" aria-hidden="true" data-toggle="tooltip"
                 title=" {{ __('Primary number') }} " data-placement="left"> </span>
            <a href="tel:{{$athlete->work_number}}">{{$athlete->primary_number}}</a></p>
        @endif
        @if($athlete->secondary_number != "")
                <!--Secondary Phone-->
        <p><span class="glyphicon glyphicon-phone-alt" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('Secondary number') }}" data-placement="left"> </span>
            <a href="tel:{{$athlete->secondary_number}}">{{$athlete->secondary_number}}</a></p>
        @endif
        @if($athlete->address || $athlete->zipcode || $athlete->city != "")
                <!--Address-->
        <p><span class="glyphicon glyphicon-home" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('Full address') }}" data-placement="left"> </span> {{$athlete->address}}
            <br/>{{$athlete->zipcode}} {{$athlete->city}}
        </p>
        @endif
        @if($athlete->company_name != "")
                <!--School or Club -->
        <p><span class="glyphicon glyphicon-education" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('Organization') }}" data-placement="left"> </span> {{$athlete->company_name}}</p>
        @endif
    </div>

    <!--Athlete info leftside END-->
    <!--Athlete info rightside-->
    <div class="contactright">
{{--         
        @if($athlete->company_type!= "")
                <!--Company Type-->
        <p><span class="glyphicon glyphicon-globe" aria-hidden="true" data-toggle="tooltip"
                 title="{{ __('Company type') }}" data-placement="left"> </span>
            {{$athlete->company_type}}</p>
        @endif  --}}
    </div>
</div>

<!--Athlete info rightside END-->
