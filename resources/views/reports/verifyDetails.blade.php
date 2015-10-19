<style>
    body {
        width: 100%;
        margin: 0;
        float: none;
        background: #fff;
        font: 1em Georgia, "Times New Roman", Times, serif;
        color: #000;
    }

    h1,h2,h3,h4,h5,h6 {
        font-family: Helvetica, Arial, sans-serif;
        color: #000;
    }
    h1 { font-size: 250%; margin-top:0; }
    h2 { font-size: 175%; }
    h3 { font-size: 135%; }
    h4 { font-size: 100%; font-variant: small-caps; }
    h5 { font-size: 100%; }
    h6 { font-size: 90%; font-style: italic; }

    a:link, a:visited {
        color: #00c;
        font-weight: bold;
        text-decoration: underline;
        content: " (" attr(href) ") ";
    }

    td, th{
        padding: 5px;
    }

    th{
        text-align: right;
    }

    .col{
        width: 49%;
        float: left;
    }

    .alert{
        display: block;
        padding: 10px;
        background: #a94442;
        color: white;
        border: 2px solid #743030;
        -webkit-print-color-adjust: exact;
    }

    .clear { clear: both; }
    .page-break	{ display: block; page-break-before: always; }

</style>

    @foreach($youths as $youth)

        <h1>{{ $youth->first_name }} {{ $youth->last_name }}</h1>

        <p>Please use this form to verify we have all the correct information for your child and yourself.
            Simply cross out any incorrect information, and write the correction next to it.</p>


        <table>
            <tr>
                <th>Full Name:</th>
                <td>
                    {{ $youth->title }} {{ $youth->first_name }} {{ $youth->middle_names }} {{ $youth->last_name }}
                </td>
            </tr>
            <tr>
                <th>Date of Birth:</th>
                <td>
                    {{ $youth->dob->format('jS F Y') }}
                </td>
            </tr>
            <tr>
                <th>Child Email:</th>
                <td>
                    {{ $youth->email }}
                </td>
            </tr>
            <tr>
                <th>Child Mobile:</th>
                <td>
                    {{ $youth->telephone }}
                </td>
            </tr>
            <tr>
                <th>Nationality:</th>
                <td>
                    {{ $youth->nationality->name }}
                </td>
            </tr>
            <tr>
                <th>Faith:</th>
                <td>
                    {{ $youth->faith->name }}
                </td>
            </tr>
            <tr>
                <th>Ethnicity:</th>
                <td>
                    {{ $youth->ethnicity->name }}
                </td>
            </tr>
            <tr>
                <th>Can swim 100m?</th>
                <td>
                    @if($youth->swim == 1)
                        Yes
                    @else
                        No
                    @endif
                </td>
            </tr>
            <tr>
                <th>Banned from using Firearms?</th>
                <td>
                    @if($youth->bannedFirearms == 1)
                        Yes
                    @else
                        No
                    @endif
                </td>
            </tr>
            <tr>
                <th>Address:</th>
                <td>
                    {{ $youth->address_line1 }}<br />
                    @unless(empty($youth->address_line2)) {{ $youth->address_line2 }}<br /> @endunless
                    @unless(empty($youth->address_line3)) {{ $youth->address_line3 }}<br /> @endunless
                    @unless(empty($youth->address_line4)) {{ $youth->address_line4 }}<br /> @endunless
                    @unless(empty($youth->postal_town)) {{ $youth->postal_town }}<br /> @endunless
                    @unless(empty($youth->postal_county)) {{ $youth->postal_county }}<br /> @endunless
                    @unless(empty($youth->postal_code)) {{ $youth->postal_code }}<br /> @endunless
                </td>
            </tr>
        </table>

        <?php $rememberIDs = [] ; ?>

        @forelse($youth->parents as $parent)

            <?php $rememberIDs[] = $parent->id; ?>

            <div class="col">
                <h2>Parent - {{ $parent->first_name }} {{ $parent->last_name }}</h2>

                <table>
                    <tr>
                        <th>Full Name:</th>
                        <td>
                            {{ $parent->title }} {{ $parent->first_name }} {{ $parent->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Gender:</th>
                        <td>
                            @if($parent->gender == 'M')
                                Male
                            @else
                                Female
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Date of Birth:</th>
                        <td>
                            @if(is_null($parent->dob))
                                Not Given
                            @else
                                {{ $parent->dob->format('jS F Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Relationship:</th>
                        <td>
                            {{ $parent->relationship }}
                        </td>
                    </tr>
                    <tr>
                        <th>Mobile:</th>
                        <td>
                            {{ $parent->telephone }}
                        </td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>
                            {{ $parent->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>Occupation:</th>
                        <td>
                            {{ $parent->occupation }}
                        </td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>
                            @if(empty($parent->address_line1))
                                {{ $parent->address_line1 }}<br />
                                Same as child
                            @else
                                {{ $parent->address_line1 }}<br />
                                @unless(empty($parent->address_line2)) {{ $parent->address_line2 }}<br /> @endunless
                                @unless(empty($parent->address_line3)) {{ $parent->address_line3 }}<br /> @endunless
                                @unless(empty($parent->address_line4)) {{ $parent->address_line4 }}<br /> @endunless
                                @unless(empty($parent->postal_town)) {{ $parent->postal_town }}<br /> @endunless
                                @unless(empty($parent->postal_county)) {{ $parent->postal_county }}<br /> @endunless
                                @unless(empty($parent->postal_code)) {{ $parent->postal_code }}<br /> @endunless
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

        @empty
            <p class="alert">No parents recorded. Please speak to a Leader.</p>
        @endforelse

        @if(count($youth->parents) > 0 )
            <div class="clear"></div>
            <div class="page-break"></div>
        @endif

        @forelse($youth->emergency_contacts as $parent)
            <div class="col">
                <h2>Emergency Contact - {{ $parent->first_name }} {{ $parent->last_name }}</h2>

                @if(in_array($parent->id, $rememberIDs))
                    As above
                @else

                <table>
                    <tr>
                        <th>Full Name:</th>
                        <td>
                            {{ $parent->title }} {{ $parent->first_name }} {{ $parent->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Gender:</th>
                        <td>
                            @if($parent->gender == 'M')
                                Male
                            @else
                                Female
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Date of Birth:</th>
                        <td>
                            @if(is_null($parent->dob))
                                Not Given
                            @else
                                {{ $parent->dob->format('jS F Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Relationship:</th>
                        <td>
                            {{ $parent->relationship }}
                        </td>
                    </tr>
                    <tr>
                        <th>Mobile:</th>
                        <td>
                            {{ $parent->telephone }}
                        </td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>
                            {{ $parent->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>Occupation:</th>
                        <td>
                            {{ $parent->occupation }}
                        </td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>
                            @if(empty($parent->address_line1))
                                {{ $parent->address_line1 }}<br />
                                Same as child
                            @else
                                {{ $parent->address_line1 }}<br />
                                @unless(empty($parent->address_line2)) {{ $parent->address_line2 }}<br /> @endunless
                                @unless(empty($parent->address_line3)) {{ $parent->address_line3 }}<br /> @endunless
                                @unless(empty($parent->address_line4)) {{ $parent->address_line4 }}<br /> @endunless
                                @unless(empty($parent->postal_town)) {{ $parent->postal_town }}<br /> @endunless
                                @unless(empty($parent->postal_county)) {{ $parent->postal_county }}<br /> @endunless
                                @unless(empty($parent->postal_code)) {{ $parent->postal_code }}<br /> @endunless
                            @endif
                        </td>
                    </tr>
                </table>

                @endif
            </div>


        @empty
            <p class="alert">No emergency contacts recorded. Please speak to a Leader.</p>
        @endforelse

        @if(count($youth->emergency_contacts) > 0 )
            <div class="clear"></div>
        @endif

        <h2>Health Information</h2>
        <table>
            <tr>
                <th>Doctor Name:</th>
                <td>
                    {{ $youth->doctor_name }}
                </td>
            </tr>
            <tr>
                <th>Address:</th>
                <td>
                    @unless(empty($youth->surgery->address_line1)) {{ $youth->surgery->address_line1 }}<br />@endunless
                    @unless(empty($youth->surgery->address_line2)) {{ $youth->surgery->address_line2 }}<br /> @endunless
                    @unless(empty($youth->surgery->address_line3)) {{ $youth->surgery->address_line3 }}<br /> @endunless
                    @unless(empty($youth->surgery->address_line4)) {{ $youth->surgery->address_line4 }}<br /> @endunless
                    @unless(empty($youth->surgery->postal_town)) {{ $youth->surgery->postal_town }}<br /> @endunless
                    @unless(empty($youth->surgery->postal_county)) {{ $youth->surgery->postal_county }}<br /> @endunless
                    @unless(empty($youth->surgery->postal_code)) {{ $youth->surgery->postal_code }}<br /> @endunless
                </td>
            </tr>
            <tr>
                <th>NHS Number:</th>
                <td>
                    {{ $youth->nhs_number }}
                </td>
            </tr>
            <tr>
                <th>Dietary Needs:</th>
                <td>
                    {{ $youth->dietary_needs }}
                </td>
            </tr>
            <tr>
                <th>Medical Info:</th>
                <td>
                    {{ $youth->medical_info }}
                </td>
            </tr>
            <tr>
                <th>Disabilities:</th>
                <td>
                    @forelse($youth->disabilities as $disability)
                        {{ $disability->name }},
                    @empty
                        None
                    @endforelse

                    @unless(empty($youth->disability_notes))
                        <br /><strong>Notes:</strong><br />
                        {{ $youth->disability_notes }}
                    @endunless
                </td>
            </tr>
        </table>

        <div class="page-break"></div>
    @endforeach