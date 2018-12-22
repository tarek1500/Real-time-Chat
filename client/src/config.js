export const domainUrl = 'http://localhost/chat/public/'
export const loginUrl = domainUrl + 'oauth/token'
export const registerUrl = domainUrl + 'api/register'
export const userInfoUrl = domainUrl + 'api/user'
export const usersUrl = domainUrl + 'api/users'
export const getChatUrl = domainUrl + 'api/chat/show'
export const sendChatUrl = domainUrl + 'api/chat/send'

// Add Client ID & Secret
export const clientId = 0, clientSecret = ''

var accessToken = null, refreshToken = null

export const setTokens = function (_accessToken, _refreshToken) {
	accessToken = _accessToken
	refreshToken = _refreshToken
}

export const getHeader = function () {
	return {
		'Accept': 'application/json',
		'Authorization': 'Bearer ' + accessToken
	}
}