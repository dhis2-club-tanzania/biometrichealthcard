class ManagementAttendedUser(CreateAPIView):
    def post(self, request, **kwargs):
        # try:
        request_flag = request.data['request_flag']
        fingerprint_device_id = request.data['fingerprint_device_id']
        print(fingerprint_device_id)
        recognized_finger_print = UbunifuUsersAndFingerPrintIDs.objects.filter(
            fingerprint_data_ID=fingerprint_device_id).all()
        if not recognized_finger_print.exists():
            return JsonResponse({'code': 400, 'message': 'Un-registered person'})

        setting_attinding_time = UbunifuAttendingSetting.objects.all()
        attinding_time = setting_attinding_time[0].setting_attinding_time
        if request_flag == "IN":
            existing_attendance = UbunifuDailyAttendence.objects.filter(
                attendence_fingerprint__fingerprint_user=recognized_finger_print[0].fingerprint_user,
                attendence_still_in=True)
            if existing_attendance.exists():
                return HttpResponse(status=204)
            else:
                new_attendane = UbunifuDailyAttendence.objects.update_or_create(
                    attendence_fingerprint_id=recognized_finger_print[0].fingerprint_id,
                    attendence_still_in=True,
                )

            sign_time = datetime.strptime(str(new_attendane[0].attendence_time_in.year) + ":" + str(
                new_attendane[0].attendence_time_in.month) + ":" + str(
                new_attendane[0].attendence_time_in.day) + ":" + str(
                new_attendane[0].attendence_time_in.hour) + ":" + str(new_attendane[0].attendence_time_in.minute),
                                          "%Y:%m:%d:%H:%M")
            date_ya_leo = datetime.strptime(str(datetime.today().strftime('%Y:%m:%d')) + ":" + str(attinding_time),
                                            "%Y:%m:%d:%H:%M:%S")
            time_interval = sign_time - date_ya_leo

        elif request_flag == "OUT":
            existing_attendance = UbunifuDailyAttendence.objects.filter(
                 attendence_fingerprint__fingerprint_user=recognized_finger_print[0].fingerprint_user, attendence_still_in=True)
            if not existing_attendance.exists():
                return HttpResponse(status=204)
            else:
                new_attendane = UbunifuDailyAttendence.objects.filter(attendence_still_in=True,
                                                                       attendence_fingerprint__fingerprint_user=recognized_finger_print[0].fingerprint_user,).all()
                sign_time = datetime.strptime(str(new_attendane[0].attendence_time_in.year) + ":" + str(
                    new_attendane[0].attendence_time_in.month) + ":" + str(
                    new_attendane[0].attendence_time_in.day) + ":" + str(
                    new_attendane[0].attendence_time_in.hour) + ":" + str(new_attendane[0].attendence_time_in.minute),
                                              "%Y:%m:%d:%H:%M")

                date_ya_leo = datetime.strptime(datetime.today().strftime('%Y-%m-%d %H:%M:%S'), '%Y-%m-%d %H:%M:%S')
                time_interval = date_ya_leo - sign_time

                new_attendane.update(
                    attendence_still_in=False,
                    attendence_time_out=date_ya_leo,
                    attendence_extra_hours=time_interval.seconds / 60 / 60
                )



        return JsonResponse({'code': 200, 'message': fingerprint_device_id})
