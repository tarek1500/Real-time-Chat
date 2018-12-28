export const domainUrl = 'http://localhost/chat/public/'
export const loginUrl = domainUrl + 'oauth/token'
export const registerUrl = domainUrl + 'api/register'
export const userInfoUrl = domainUrl + 'api/user'
export const usersUrl = domainUrl + 'api/users'
export const getChatUrl = domainUrl + 'api/chat/show'
export const sendChatUrl = domainUrl + 'api/chat/send'
export const sendMessageUrl = domainUrl + 'api/pm/send'
export const getInboxUrl = domainUrl + 'api/pm/inbox'
export const getOutboxUrl = domainUrl + 'api/pm/outbox'
export const showMessageUrl = domainUrl + 'api/pm/show'
export const pusherEndpointUrl = domainUrl + 'broadcasting/auth'

// Add Client ID & Secret
export const clientId = 0, clientSecret = ''
// Add Pusher Key & Cluster & Host & Port
export const pusherKey = '', pusherCluster = '', pusherHost = '', pusherPort = 0

var accessToken = null, refreshToken = null

export const setTokens = function (_accessToken, _refreshToken) {
	accessToken = _accessToken
	refreshToken = _refreshToken
}

export const clearTokens = function () {
	accessToken = null
	refreshToken = null
}

export const getHeader = function (key = '', value = '') {
	let header = {
		'Accept': 'application/json',
		'Authorization': 'Bearer ' + accessToken
	}

	if (key)
		header[key] = value

	return header
}