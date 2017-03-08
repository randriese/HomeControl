cmd = ''
for device,status in pairs(devicechanged) do cmd = cmd..device.."|"..status.."#" end
os.execute('curl -s -d "c='..cmd..'" http://127.0.0.1/entry.php &')
return {}
