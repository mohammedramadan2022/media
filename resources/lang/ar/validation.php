<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'يجب قبول حقل :attribute',
    'active_url'           => 'حقل :attribute لا يُمثّل رابطًا صحيحًا',
    'after'                => 'يجب على حقل :attribute أن يكون تاريخًا لاحقًا لـ :date.',
    'after_or_equal'       => 'حقل :attribute يجب ان يكون بتاريخ لاحق او مساوي لي :date',
    'alpha'                => 'يجب أن لا يحتوي حقل :attribute سوى على حروف',
    'alpha_dash'           => 'يجب أن لا يحتوي حقل :attribute على حروف، أرقام ومطّات.',
    'alpha_num'            => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array'                => 'يجب أن يكون حقل :attribute ًمصفوفة',
    'before'               => 'يجب على حقل :attribute أن يكون تاريخًا سابقًا لحقل :date.',
    'before_or_equal'      => 'حقل :attribute يجب ان يكون بتاريخ سابق او مساوي لي :date',
    'between'              => [
        'numeric' => 'يجب أن تكون قيمة :attribute محصورة ما بين :min و :max.',
        'file'    => 'يجب أن يكون حجم الملف :attribute محصورًا ما بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن يكون عدد حروف النّص :attribute محصورًا ما بين :min و :max',
        'array'   => 'يجب أن يحتوي :attribute على عدد من العناصر محصورًا ما بين :min و :max',
    ],
    'boolean'              => 'يجب أن تكون قيمة حقل :attribute إما true أو false ',
    'confirmed'            => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'date'                 => 'حقل :attribute ليس تاريخًا صحيحًا',
    'date_equals'          => 'حقل :attribute يجب ان يكون تاريخ مساوي لي :date',
    'date_format'          => 'لا يتوافق حقل :attribute مع الشكل :format.',
    'different'            => 'يجب أن يكون حقلان :attribute و :other مُختلفان',
    'digits'               => 'يجب أن يحتوي حقل :attribute على :digits رقمًا/أرقام',
    'digits_between'       => 'يجب أن يحتوي حقل :attribute ما بين :min و :max رقمًا/أرقام ',
    'dimensions'           => 'حقل :attribute يجب ان يكون بابعاد صورة صحيحة',
    'distinct'             => 'حقل :attribute بقيمة مكررة',
    'email'                => 'حقل :attribute يجب ان يكون بريد الكتروني صالح',
    'ends_with'            => 'حقل :attribute يجب ان ينتهي بأحد القيم التالية :values',
    'exists'               => 'حقل :attribute غير  موجود',
    'file'                 => 'حقل :attribute يجب ان يكون ملف',
    'filled'               => 'حقل :attribute يجب ان يحتوي علي قيمة',
    'gt'                   => [
        'numeric' => 'حقل :attribute يجب ان يكون بقيمة اكبر من :value',
        'file'    => 'حقل :attribute يجب ان يكون بمساحة اكبر من :value كيلوبيت',
        'string'  => 'حقل :attribute يجب ان يكون بعدد احرف اكبر من :value حرف',
        'array'   => 'حقل :attribute يجب ان يكون بعدد عناصر اكبر من :value عنصر',
    ],
    'gte'                  => [
        'numeric' => 'حقل :attribute يجب ان يكون اكبر من او يساوي :value',
        'file'    => 'حقل :attribute يجب ان يكون بمساحة أكبر من او تساوي :value كيلوبيت',
        'string'  => 'حقل :attribute يجب ان يكون بعدد أحرف اكبر من او تساوي :value حرف',
        'array'   => 'حقل :attribute يجب ان يكون بعدد :value عنصر او اكبر ',
    ],
    'image'                => 'حقل :attribute يجب ان يكون صورة',
    'in'                   => 'حقل :attribute غير صحيح',
    'in_array'             => 'حقل :attribute غير موجود من ضمن :other',
    'integer'              => 'حقل :attribute يجب ان يكون رقمي صحيح',
    'ip'                   => 'حقل :attribute يجب ان يكون IP صحيح',
    'ipv4'                 => 'حقل :attribute يجب ان يكون IPv4 صحيح',
    'ipv6'                 => 'حقل :attribute يجب ان يكون IPv6 صحيح',
    'json'                 => 'حقل :attribute يجب ان يكون بصيغة JSON صحيحة',
    'lt'                   => [
        'numeric' => 'حقل :attribute يجب ان يكون اقل من :value',
        'file'    => 'حقل :attribute يجب ان يكون بمساحة اقل من :value كيلوبيت',
        'string'  => 'حقل :attribute يجب ان يكون اقل من :value حرف',
        'array'   => 'حقل :attribute يجب ان يكون اقل من :value عنصر',
    ],
    'lte'                  => [
        'numeric' => 'حقل :attribute يجب ان يكون اقل من او يساوي :value',
        'file'    => 'حقل :attribute يجب ان يكون بمساحة اقل من او تساوي :value كيلوبيت',
        'string'  => 'حقل :attribute يجب ان يكون اقل من او يساوي :value حرف',
        'array'   => 'حقل :attribute يجب ان يكون اقل من او يساوي :value عنصر',
    ],
    'max'                  => [
        'numeric' => 'حقل :attribute يجب ان لا يزيد عن :max',
        'file'    => 'حقل :attribute يجب الا يكون بحجم اكبر من :max كيلوبيت',
        'string'  => 'حقل :attribute يجب ان لا يزيد عن :max حرف',
        'array'   => 'حقل :attribute يجب ان لا يزيد عن :max عنصر',
    ],
    'mimes'                => 'حقل :attribute يجب ان يكون بالامتدادات الاتية : :values',
    'mimetypes'            => 'حقل :attribute يجب ان يكون بالامتدادات الاتية : :values',
    'min'                  => [
        'numeric' => 'حقل :attribute يجب ان لا يقل عن :min',
        'file'    => 'حقل :attribute يجب ان يكون بمساحة لا تقل عن :min كيلوبيت',
        'string'  => 'حقل :attribute يجب ان لا يقل عن :min حروف',
        'array'   => 'حقل :attribute يجب ان يحتوي علي الاقل علي :min عنصر',
    ],
    'not_in'               => 'حقل :attribute يجب ان يكون بقيمة صحيحة',
    'not_regex'            => 'حقل :attribute بصيغة غير صحيحة',
    'numeric'              => 'حقل :attribute يجب ان يكون رقمي',
    'present'              => 'حقل :attribute يجب ان يكون في الحاضر',
    'regex'                => 'حقل :attribute بصيغة خاطئة',
    'required'             => 'حقل :attribute مطلوب.',
    'required_if'          => 'حقل :attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless'      => 'حقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with'        => 'حقل :attribute إذا توفّر :values.',
    'required_with_all'    => 'حقل :attribute إذا توفّر :values.',
    'required_without'     => 'حقل :attribute إذا لم يتوفّر :values.',
    'required_without_all' => 'حقل :attribute إذا لم يتوفّر :values.',
    'same'                 => 'حقل :attribute يجب ان يتماشي مع :other',
    'size'                 => [
        'numeric' => 'حقل :attribute يجب ان يكون :size',
        'file'    => 'حقل :attribute يجب ان يكون :size كيلوبيت',
        'string'  => 'حقل :attribute يجب ان يكون :size حرف',
        'array'   => 'حقل :attribute يجب ان يحتوي علي :size عنصر',
    ],
    'starts_with'          => 'حقل :attribute يجب ان يبدا باحد القيم التالية :values',
    'string'               => 'حقل :attribute يجب ان يكون نص',
    'timezone'             => 'حقل :attribute يجب ان يكون منطقة زمنية صحيحة',
    'unique'               => 'حقل :attribute موجود بالفعل',
    'uploaded'             => 'فشل تحميل :attribute',
    'url'                  => 'حقل :attribute بصيغة غير صحيحة',
    'uuid'                 => 'حقل :attribute يجب ان يكون UUID صحيح',

    'mak_words'      => 'حقل :attribute يجب ان يكون  رباعي',
    'youtube_link'   => 'حقل :attribute يجب ان يكون رابط يوتيوب',
    'is_ar'          => 'حقل :attribute يجب ان يكون باللغة العربية',
    'without_spaces' => 'حقل :attribute يجب ان لا يجتوي علي مسافات',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'ar.answer'             => 'الجواب باللغة العربية',
        'en.answer'             => 'الجواب باللغة الانجليزية',
        'ar.question'           => 'السؤال باللغة العربية',
        'en.question'           => 'السؤال باللغة الانجليزية',
        'ar.name'               => 'الاسم باللغة العربية',
        'en.name'               => 'الاسم باللغة الانجليزية',
        'ar.desc'               => 'الوصف باللغة العربية',
        'en.desc'               => 'الوصف باللغة الانجليزية',
        'ar.description'        => 'الوصف باللغة العربية',
        'en.description'        => 'الوصف باللغة الانجليزية',
        'ar.title'              => 'العنوان باللغة العربية',
        'en.title'              => 'العنوان باللغة الانجليزية',
        'ar.content'            => 'المحتوي باللغة العربية',
        'en.content'            => 'المحتوي باللغة الانجليزية',
        'ar.body'               => 'المحتوي باللغة العربية',
        'en.body'               => 'المحتوي باللغة الانجليزية',
        'ar.subtitle'           => 'العنوان الفرعي باللغة العربية',
        'en.subtitle'           => 'العنوان الفرعي باللغة الانجليزية',
        'ar.usage_instructions' => 'إرشادات الإستخدام باللغة العربية',
        'en.usage_instructions' => 'إرشادات الإستخدام باللغة الانجليزية',
        'ar.rental_terms'       => 'شروط الإيجار باللغة العربية',
        'en.rental_terms'       => 'شروط الإيجار باللغة الانجليزية',

        'video_link'                 => 'رابط الفيديو',
        'cost'                       => 'التكلفة',
        'image'                      => 'الصورة',
        'latitude'                   => 'خط الطول',
        'longitude'                  => 'خط العرض',
        'chairs'                     => 'عدد الكراسي',
        'ammount'                    => 'الكمية',
        'price'                      => 'السعر',
        'name'                       => 'الاسم',
        'email'                      => 'البريد الالكتروني',
        'password'                   => 'كلمة المرور',
        'phone'                      => 'رقم الجوال',
        'commercial_registration_no' => 'رقم السجل التجاري',
        'shop_name'                  => 'اسم المحل',
        'shop_address'               => 'عنوان المحل',
        'date'                       => 'التاريخ',
        'neighborhood'               => 'الحي',
        'street'                     => 'الشارع',
        'bride_name'                 => 'اسم العروسة',
        'userData'                   => 'بيانات العضو',
        'userData.name'              => 'الاسم',
        'userData.email'             => 'البريد الالكتروني',
        'userData.phone'             => 'الهاتف',
        'userData.city_id'           => 'المدينة',

        'reservation_date'      => 'تاريخ الحجز',
        'hall_id'               => 'رقم القاعة',
        'to'                    => 'المرسل اليه',
        'message'               => 'الرسالة',
        'subject'               => 'عنوان الرسالة',
        'code'                  => 'الكود',
        'sms_code'              => 'كود الرسالة',
        'city_id'               => 'المدينة',
        'delegate_identity'     => 'المندوب',
        'start_time'            => 'بداية دوام الفترة الاولي',
        'end_time'              => 'نهاية دوام الفترة الاولي',
        'identity'              => 'الهوية',
        'bank_name'             => 'إسم البنك',
        'bank_account_no'       => 'رقم الحساب البنكي',
        'category_id'           => 'الفئة',
        'lat'                   => 'خط الطول',
        'long'                  => 'خط العرض',
        'market_id'             => 'المحل',
        'rate'                  => 'التقيم',
        'comment'               => 'التعليق',
        'ended_at'              => 'تاريخ الانتهاء',
        'value'                 => 'القيمة',
        'second_start_time'     => 'بداية دوام الفترة الثانية',
        'second_end_time'       => 'نهاية دوام الفترة الثانية',
        'whatsapp'              => 'رقم الوتس اب',
        'coupon_no'             => 'الكوبون',
        'state'                 => 'الحي',
        'role_id'               => 'الصلاحية',
        'database'              => 'قاعدة البيانات',
        'title'                 => 'العنوان',
        'link'                  => 'الرابط',
        'user_id'               => 'العضو',
        'address'               => 'العنوان',
        'specialization'        => 'التخصص',
        'crn'                   => 'رقم السجل التجاري',
        'year_founded'          => 'سنة التأسيس',
        'body'                  => 'المحتوي',
        'new_cases'             => 'الحالات الجديدة',
        'cases_from_pos_to_nig' => 'الحالات من ايجابي الي سلبي',
        'new_deaths'            => 'الوافيات الجديدة',
        'total_cases'           => 'اجمالي الحالات المصابة',
        'recovery_cases'        => 'الحالات التي تم شفائها',
        'total_deaths'          => 'اجمالي حالات الوفيات',
        'newPassword'           => 'كلمة المرور الجديدة',
        'start_date'            => 'تاريخ البدأ',
        'end_date'              => 'تاريخ الانتهاء',
        'currentPassword'       => 'كلمة المرور الحالية',
        'slug'                  => 'اسم لينك الصفحة',
        'service_name'          => 'إسم الخدمة',
        'service_type'          => 'نوع النشاط',
        'service_desc'          => 'وصف الخدمة المطلوبة',
        'service_extra'         => 'ملحقات خاصة بالخدمة',
        'days'                  => 'مدة الباقة بالايام',
        'bank_id'               => 'البنك',
        'account_number'        => 'رقم الحساب',
        'iban_number'           => 'رقم iban',
        'desc'                  => 'الوصف',
        'section_id'            => 'القسم',
        'agency_id'             => 'المنشأة',
        'country_id'            => 'البلد',
        'type'                  => 'النوع',

        'gender'     => 'الجنس',
        'unit_price' => 'سعر الوجدة',
        'job'        => 'الوظيفة',
        'age'        => 'السن',
        'linkedin'   => 'حساب لينكدان',
        'program'    => 'البرنامج',
        'entity'     => 'الجهة',

        'categories.*.maincategory_id' => 'الفئة الرئيسية',
        'categories.*.subcategory_id'  => 'الفئة الفرعية',

        'description'  => 'الوصف',
        'project_id'   => 'المشروع',
        'country_code' => 'مفتاح الدولة',
        'zip_code'     => 'الرمز البريدي',
        'images.*'     => 'الصور',

        'package_id'   => 'الباقة',
        'provider_id'  => 'مقدم الخدمة',
        'repair_id'    => 'طلب الاصلاح',
        'new_password' => 'كلمة المرور الجديدة',

        'categories'              => 'الفئات',
        'fname'                   => 'الاسم الاول',
        'lname'                   => 'الاسم الاخير',
        'username'                => 'اسم المستحدم',
        'course_id'               => 'الدورة',
        'filename'                => 'الملف',
        'subject_id'              => 'الموضوع',
        'sub_subject_id'          => 'المادة الفرعية',
        'into_video'              => 'الفيديو التجريبي',
        'university_id'           => 'الجامعة',
        'expired_at'              => 'تاريخ الانتهاء',
        'subjects'                => 'المواد الاساسية',
        'account_no'              => 'رقم الحساب البنكي',
        'beneficiary_name'        => 'إسم المستفيد',
        'for'                     => 'الشخص المستهدف',
        'subscription_id'         => 'الاشتراك',
        'video_id'                => 'الفيديو',
        'doctor_id'               => 'الدكتور',
        'main_subject_id'         => 'الفئة الرئيسية',
        'coupon'                  => 'الكوبون',
        'course_comment'          => 'التعليق',
        'images'                  => 'الصور',
        'instagram'               => 'حساب الانستجرام',
        'identification_number'   => 'رقم الهوية الشخصية',
        'commercial_record_image' => 'الصورة',
        'trade_name_ar'           => 'الاسم التجاري بالعربية',
        'trade_name_en'           => 'الاسم التجاري بالانجليزية',
        'member_price'            => 'سعر الرحلة للفرد البالغ',
        'child_price'             => 'سعر الرحلة للطفل',
        'names.*'                 => 'الاسم',
        'prices.*'                => 'السعر',
        'services'                => 'الخدمات',
        'sections'                => 'الاقسام',
        'cancel_days_count'       => 'وقت الإلغاء المسموح به',
        'dates'                   => 'التواريخ',
        'area_id'                 => 'المنطقة',
        'hours'                   => 'الساعات',
        'hour_cost'               => 'سعر الحجز في الساعة',
        'bio'                     => 'نبذه',
        'reservation_time'        => 'التوقيت',
        'photo'                   => 'الصورة',
        'trainer_id'              => 'المدرب',
        'file.*'                  => 'الملف',
        'foreground'              => 'الصورة',
        'background'              => 'الصورة',
        'tasks_ar.*'              => 'الحقول باللغة العربية',
        'tasks_en.*'              => 'الحقول باللغة الانجليزية',
        'fields_ar.*'             => 'الحقول باللغة العربية',
        'fields_en.*'             => 'الحقول باللغة الانجليزية',
        'titles_ar.*'             => 'العناوين باللغة العربية',
        'titles_en.*'             => 'العناوين باللغة الانجليزية',
        'mobile'                  => 'الجوال',
        'company'                 => 'الشركة',
        'job_type'                => 'نوع الوظيفة',
        'opinion'                 => 'الرأي',
        'created_at'              => 'تاريخ الإضافة',
        'work_quality'            => 'جودة العمل',
        'speed_of_delivery'       => 'سرعة التسليم/التنفيذ',
        'staff_performance'       => 'أداء الموظفين',
        'after_sales'             => 'خدمة ما بعد البيع/التنفيذ',
        'recommend_us'            => 'التوصية',
        'magazine_id'             => 'المجلة',
        'file_name'               => 'العدد',
        'first_name'              => 'الإسم الأول',
        'last_name'               => 'الإسم الأخير',
        'url'                     => 'الرابط الخارجي',
        'recipient_name'          => 'إسم المستلم',
        'special_marque'          => 'العلامة مميزة',
        'branches'                => 'فروع متجرك',
        'logo'                    => 'شعار المتجر',
        'store_name'              => 'إسم المتجر',
        'startDate'               => 'تاريخ الاستلام',
        'startTime'               => 'وقت الاستلام',
        'endDate'                 => 'تاريخ التسليم',
        'endTime'                 => 'وقت التسليم',
        'amount'                  => 'قيمة الشحن',
        'card_numbers'            => 'رقم الكارت',
        'card_holder'             => 'اسم حامل البطاقة',
        'card_date'               => 'تاريخ انتهاء الصلاحية',
        'card_cvv'                => 'الكود',
        'address_id'              => 'عنوان التوصيل',
        'qty'                     => 'الكمية',
        'owner_id'                => 'التاجر',
        'offer'                   => 'العرض',
        'file'                    => 'الملف',
        'video_url'               => 'رابط الفيديو',
        'map_url'                 => 'رابط العنوان علي الخريطة',
        'dropdown'                => 'نوع القائمة المنسدلة',
        'names_ar.*'              => 'الاسم بالعربية',
        'names_en.*'              => 'الاسم بالانجليزية',
        'specs'                   => 'الخصائص',
        'hour_price'              => 'سعر ساعة الإيجار',
    ],
];
