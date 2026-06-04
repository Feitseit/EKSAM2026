Import-Module ActiveDirectory

# Määrame grupi nime
$GroupName = "PilveKasutajad"

# Loome grupi (kui seda pole veel olemas)
if (!(Get-ADGroup -Filter "Name -eq '$GroupName'" -ErrorAction SilentlyContinue)) {
    New-ADGroup -Name $GroupName -GroupScope Global -GroupCategory Security -Description "Grupp kasutajatele, kelle Desktop ja Documents suunatakse serverisse"
    Write-Host "Grupp $GroupName on loodud Active Directorys."
} else {
    Write-Host "Grupp $GroupName on juba olemas."
}
