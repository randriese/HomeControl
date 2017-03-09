cmd = ''
for device,status in pairs(devicechanged) do cmd = cmd..device.."|"..status.."#" end
os.execute('curl -s -d "c='..cmd..'" http://192.168.1.62/entry.php &')
commandArray = {}
return commandArray