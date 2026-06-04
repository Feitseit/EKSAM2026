# Määratleme muutujad
$FolderName = "KasutajateFailid"
$FolderPath = "F:\$FolderName"
$ShareName = "$FolderName`$" # '$' lõpus teeb kausta võrgus peidetuks

# 1. Loome kausta, kui seda pole veel olemas
if (!(Test-Path -Path $FolderPath)) {
    New-Item -ItemType Directory -Path $FolderPath | Out-Null
    Write-Host "Kaust $FolderPath on loodud."
}

# 2. Jagame kausta ja anname administraatoritele täisõigused
# Märkus: Active Directory (AD) peaks olema töös, et saaksime määrata 'Domain Users' grupi
$EveryoneGroup = "NT AUTHORITY\Authenticated Users"
$DomainAdmins = " BUILTIN\Administrators"

# Eemaldame pärilikkuse (soovi korral), et luua puhas jagatud kaust
# Jätame vaikimisi pärilikkuse, kuid lisame uued õigused:
$acl = Get-Acl -Path $FolderPath
$rule = New-Object System.Security.AccessControl.FileSystemAccessRule($EveryoneGroup, "Modify", "ContainerInherit,ObjectInherit", "None", "Allow")
$acl.SetAccessRule($rule)
Set-Acl -Path $FolderPath $acl

# Jagame kausta välja
New-SmbShare -Name $ShareName -Path $FolderPath -FullAccess $DomainAdmins -ChangeAccess "Authenticated Users" -Description "Peidetud ühiskaust kasutajate failidele"
Write-Host "Võrguketas $ShareName on jagatud!"
