# Migrating data from the previous version


## Model mappings

### Organization
Table: `dbo.ONGs`

```ini
[Id] => id
[Name] => name
[LogoImageId] => media library -> logo collection
[Description] => description
[AnualReportFileId] => media library -> default collection
[Recommendations] => ?
[CIF] => cif
[Address] => address
[PhoneNb] => contact_phone
[Email] => contact_email
[ContactPerson] => contact_person
[WebSite] => website
[HasVolunteering] => accepts_volunteers
[WhyVolunteer] => why_volunteer
[ONGStatusId] => {
   1	Approval -> OrganizationStatus::pending
   2	Active   -> OrganizationStatus::approved
   3	Inactive -> OrganizationStatus::rejected
}
[ONGApprovalStatusTypeId] => ?
[CreationDate] => created_at
[HasChanges] => ?
[MerchantId] => eu_platesc_merchant_id
[MerchantKey] => eu_platesc_private_key
[AllCounties] => X
[OrganizationalStatusId] => media library -> statute collection
[Tags] => x
[FacebookPageLink] => facebook
[DynamicUrl] => slug
```

### Activity Domain
Table: `lkp.ActivityDomains`

```ini
[Id] => id
[Name] => name
slug([Name]) => slug
```

### User
```ini
[Id] => id
[FirstName] + [LastName] => name
[Email] => email
[Password] => old_password
[PasswordSalt] => old_salt
[CreationDate] => created_at
[ActivationCodeGeneratedDate] => email_verified_at
[RoleId] => {
  1 => UserRole::USER
  2 => UserRole::ADMIN => needs organization_id from `dbo.UserONGs`
  3 => UserRole::SUPERADMIN
}
```
