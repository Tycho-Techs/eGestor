########################################################################
# Script created by Sabre Ammar, Cesar Almeida and Arjun Mohan
# 09/03/2023
#
# **Notes**
# Script created based on the idea and basis here:
# https://endjin.com/blog/2020/12/how-to-update-credentials-for-an-on-prem-power-bi-data-source-using-powershell
########################################################################

#region Initialize
# EncryptGatewayCredentials script path
$EncryptCredentialsScriptPath = "<path to the 'EncryptGatewayCredentials' script>"

# Update datasource API details 
$datasourceName = ""
$datasourceType = ""
$GatewayId = ""
$CreateDatasourceUrl = "https://api.powerbi.com/v1.0/myorg/gateways/$GatewayId/datasources"

# Service Principal credentials
$Secret = ""
$AppID = "" 
$AppPassword = ConvertTo-SecureString $Secret -AsPlainText -Force
$Credential = New-Object PSCredential $AppID, $AppPassword
$TenantID = ""

# Acquire token for Service Principal
Connect-PowerBIServiceAccount -Tenant $TenantID -ServicePrincipal -Credential $Credential

# In this case we are using an example to create a datasource for an On-Prem SQL database using "Windows credentials"
# The username here is the windows username, so this is why it needs to contain the domain.
# Be mindful of the permission levels the user has on the database
# The password is written here in plain text for convenience, in production, we recommend that you use KeyVault and store the password securely there.
$username = ""
# password = SQL user password in case of basic credentials, or windows user password in case of windows credentials
$password = ''
# Get the Gateway data for the encryption process
$gw = Invoke-PowerBIRestMethod `
                -Url "https://api.powerbi.com/v1.0/myorg/gateways/$GatewayId" `
                -Method GET ` | ConvertFrom-Json                

# On-Prem Gateway exponent
$gatewayExponent = $gw.publicKey.exponent

# On-Prem Gateway modulus which you can get using https://learn.microsoft.com/en-us/rest/api/power-bi/gateways/get-gateway API
$gatewayModulus = $gw.publicKey.modulus

#endregion

# Encrypt credentials using EncryptGatewayCredentials script and create request body
Import-Module $EncryptCredentialsScriptPath

# On the line below, change the "EncryptWindowsCredentials" according to the credentials you are using
# Please check the "EncryptGatewayCredentials" script for the supported credentials
$encryptedCredentials = EncryptWindowsCredentials -Username $username -PasswordAsString $password -GatewayExponent $gatewayExponent -GatewayModulus $gatewayModulus
$credentialsObject = $encryptedCredentials | ConvertFrom-Json
$credentialDetails = $credentialsObject.credentialDetails

$Body = @{
    "datasourceType"=$datasourceType
    "connectionDetails"='{"server":"<serverName>","database":"<DBName>"}'
    "datasourceName"=$datasourceName
    "credentialDetails" = @{
        "credentialType" = $credentialDetails.credentialType
        "credentials" = $credentialDetails.credentials
        "encryptedConnection" =  $credentialDetails.encryptedConnection
        "encryptionAlgorithm" = $credentialDetails.encryptionAlgorithm
        "privacyLevel" = $credentialDetails.privacyLevel
    }
}
$bodyJson = $body | ConvertTo-Json

Invoke-PowerBIRestMethod -Url $CreateDatasourceUrl -Method Post -Body $bodyJson
