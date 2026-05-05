<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: x-small;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .table-sm {
            font-size: 12px;
            /* You can adjust the size as needed */
        }

        p {
            font-size: 12px;
        }

        .page-break {
            page-break-after: always;
        }

        .company-details {
            text-align: right;
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <td>
            <td><img src="logo.png" alt="Company Logo"></td>
            </td>
            <td>
                <div class="company-details">
                    <h2>Dynamic Learning Strategy Sdn. Bhd
                    </h2>
                    <small>Unit 406, Block A, Level 4</small>
                    <small>Kelana Business Centre</small><br>
                    <small>No 97, Jalan SS7/2, Kelana Jaya</small><br>
                    <small>47301, Petailing Jaya,</small><br>
                    <small>Selangor, Malaysia</small><br>
                    <small>
                        enquiry@madabouteducation.com</small>
                </div>
            </td>
        </tbody>
    </table>
    <br> <br>
    @foreach ($order->children as $child)
        <h3>Program Details</h3>
        <table>
            <tr>
                <th>Payment Order ID</th>
                <td>{{ $order->full_id }}</td>
            </tr>
            <tr>
                <th>Payment Status</th>
                <td>{{ $order->payment_status->description }} {{ isset($order->paid_at) ? '-' . $order->paid_at : '' }}
                </td>
            </tr>
            <tr>
                <th>Program Name</th>
                <td>{{ $order->program_title }}</td>
            </tr>
            <tr>
                <th>Program Venue</th>
                <td>{{ $order->bookedProgram->venue }}</td>
            </tr>
            <tr>
                <th>Program Date</th>
                <td>{{ $order->bookedProgram->start_date }} - {{ $order->bookedProgram->end_date }}</td>
            </tr>
            <tr>
                <th>Pick & Drop</th>
                <td>{{ $order->bookedProgram->pick_and_drop }}</td>
            </tr>
        </table>
        <h3>Child Details #{{ $loop->iteration }}</h3>

        <table class="table-sm">
            <tr>
                <th>Name</th>
                <td>{{ $child->name }}</td>
            </tr>
            <tr>
                <th>Age</th>
                <td>{{ $child->age }}</td>
            </tr>
            <tr>
                <th>IC/ Passport No:</th>
                <td>{{ $child->passport_no }}</td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td>{{ $child->date_of_birth }}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{{ $child->gender }}</td>
            </tr>
            <tr>
                <th>Nationality</th>
                <td>{{ $child->nationality }}</td>
            </tr>
            <tr>
                <th>Name of school attending</th>
                <td>{{ $child->name_of_school_attending }}</td>
            </tr>
            <tr>
                <th>Current grade in school</th>
                <td>{{ $child->current_grade_in_school }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <h4>Guardian Details</h4>
                    <table class="table-sm">
                        <tr>
                            <th>Name</th>
                            <td>{{ $child->guardianDetails()->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Contact No.</th>
                            <td>{{ $child->guardianDetails()->contact_no ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Relationship</th>
                            <td>{{ $child->guardianDetails()->relationship ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $child->guardianDetails()->email ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Home address</th>
                            <td>{{ $child->guardianDetails()->residential_address ?? '' }}</td>
                        </tr>

                    </table>
                </td>
                <td>
                    @if ($child->guardian2Details())
                        <h4>Additional Guardian Details</h4>
                        <table class="table-sm">
                            <tr>
                                <th>Name</th>
                                <td>{{ $child->guardian2Details()->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Contact No.</th>
                                <td>{{ $child->guardian2Details()->contact_no ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Relationship</th>
                                <td>{{ $child->guardian2Details()->relationship ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $child->guardian2Details()->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Home address</th>
                                <td>{{ $child->guardian2Details()->residential_address ?? '' }}</td>
                            </tr>

                        </table>
                    @endif
                </td>
            </tr>
        </table>

        @php
            $questions = $child->questionDetails();
        @endphp
        @if (count($questions))
            <div class="page-break"></div>
            <h3>Questionnaire | {{ $child->name }}</h3>

            <table class="table-sm">
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                </tr>
                @forelse ($child->questionDetails() as $question)
                    <tr>
                        <td>{{ $question['title'] }}</td>
                        <td>{{ $question['answer'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No Questionaire Found</td>
                    </tr>
                @endforelse
            </table>
            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endif
    @endforeach

    <div>
        <h3>Conditions of Registrations:</h3>
        <p>
            I understand that the Registration forms cannot be processed unless signed and accompanied by payment. M.A.E
            Group reserves the right to cancel a camper’s enrolment if camp fees are not paid in full before a camper’s
            arrival at camp.
        </p>

        <p>
            I understand that all information collected will be used to diagnose, treat or maintain my child’s physical
            or
            mental health and to assist in preventing disease or injury or to promote health. This information is
            considered
            to be confidential and will be shared among health care providers as needed.
        </p>

        <p>
            To the best of my knowledge, my child is in good health. I will notify the camp in writing prior to arrival
            if
            there is any change in my child’s health, or he/she is exposed to any communicable disease within 1 week
            prior
            to arrival at camp.
        </p>

        <p>
            In case of medical emergency, I understand that every effort will be made to contact parents or guardians.
        </p>

        <p>
            In case of an accident or untoward incident, I give my consent for any necessary medical treatment and agree
            to
            meet any expenses incurred.
        </p>

        <p>
            I give permission to the facilitators of M.A.E. Group to transport this camper off camp property for the
            purpose
            of medical care or to participate in programs which involves leaving the camp premises (e.g. waterfall
            trekking
            and hiking).
        </p>

        <p>
            M.A.E. Group will take a variety of photographs and / or videos of the camp activities. These photos /
            videos
            may be posted in the company’s website, Facebook and other social media page, or used for promotional
            purposes
            (e.g. brochures, exhibition, news etc.) but NO names will be used.
        </p>

        <h3>Terms and Conditions:</h3>
        <p>
            MAE Group reserves the right, at their sole discretion, to dismiss a camper whole influence or actions are
            deemed to be unsatisfactory or detrimental to the Camp or who will not live within the rules and policies of
            the
            Camp. If this occurs, no reduction or return of the fee or any part thereof will be made. Camper’s parents
            and/or guardian will be required to complete a camper’s questionnaire as well as provide the Camp with a
            medical
            certificate signed by the camper’s health care professional prior to the start date of Camp. The Directors
            reserve the right to reject the camper’s application if the camper’s personal questionnaire or medical
            certificates are unclear, incomplete or if the information contained therein will cause the Camp to
            fundamentally alter the nature of its program or services. In order to reasonably accommodate each
            particular
            situation, the Directors must be made aware of children who are or have been treated for emotional,
            neurological, physical or psychiatric disorder, during the past school year. Due to fixed costs and
            expenditure
            based on definite enrolment and dates, no refunds or reductions can be made for late arrival or early
            withdrawal. Camp is not responsible for camper’s articles of clothing or personal belongings lost or damaged
            by
            fire, theft, laundry etc. It is highly recommended that campers do not bring valuable items such as
            expensive
            clothing, jewellery, cameras, electronic or musical instruments to Camp. Enrolment is subject to
            availability of
            space. Should a camper need to be sent home due to illness or injury, all related expenses will be paid by
            the
            parents and/or guardian.
        </p>

        <p>
            As parent and /or guardian, my child has permission to participate in all camp programs, camp trips and
            special
            outings planned and supervised by MAE Group. I understand that part of camping experience involves
            activities,
            group living arrangements and interactions that may be new to my child, and they come with certain risks and
            uncertainties beyond what my child may be used to dealing with at home. I am aware of these risks, and am
            assuming them on behalf of my child. I realised that no environment is risk-free and I have instructed my
            child
            on the importance of abiding by the camp rules. My child and I both agree that he or she is familiar with
            these
            rules and will obey them. As parent and/or legal guardian, I give MAE Group the permission to reproduce and
            publish any photographs, videotapes, interviews or likeness of my child for advertising, commercials and any
            other purpose in any medium. As a parent and/or guardian, I authorise any physician, nurse or other health
            care
            provider, to communicate with the director of MAE Group about my child’s medical condition, treatment,
            and/or
            prognosis. In the event I cannot be reached in an emergency when my child is under MAE Group’s supervision
            or if
            in the sole opinion of the Camp there is insufficient time due to the nature of the injury, I hereby give
            permission to the physician selected by MAE Group Director to hospitalise, secure proper treatment for and
            to
            order injections, anaesthesia or surgery for my child. All such expenses shall be paid by the parent and/or
            guardian if not otherwise covered by the camper’s health and medical insurance.
        </p>
    </div>
</body>

</html>
