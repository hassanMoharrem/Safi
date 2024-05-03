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
    };

window.__ = function(key, locale)
{
    if (locale === 'ar') {
        return lang[key] || key;
    } else {
        return key;
    }
}

