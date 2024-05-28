const lang =
    {
        'Safi' :"صافي",
        'Create User' :"إنشاء مستخدم",
        'Click to Add Your Profile Image' :"إضغط لإضافة صورة",
        'Name' :"الإسم",
        'Number System' :"عدد أنظمة التحلية",
        'Email' :"الإيميل",
        'Phone' :"رقم الهاتف",
        'Password' :"كلمة المرور",
        'Action' :"التحكم",
        'Table' :"جدول العرض",
        'Yes , Delete' :"نعم ، حذف",
        'Empty' :"فارغ",
        'Are you sure to delete this user ?' :"هل أنت متأكد من عمليت الحذف ؟",
        'Station' :"أنظمة",
        'Number Phase' :"عدد المراحل",
        'Data is null' :"لا يوجد بيانات",
        'Create dessert Station' :"إنشاء نظام تحلية",
        'Save changes' :"حفظ التغيرات",
        'Close' :"إغلاق",
    };

window.__ = function(key, locale)
{
    if (locale === 'ar') {
        return lang[key] || key;
    } else {
        return key;
    }
}

