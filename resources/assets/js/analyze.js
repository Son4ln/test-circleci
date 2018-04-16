import axios from 'axios'
import Chart from './libs/Chart'

// Setup axios
axios.defaults = {
  // `headers` are custom headers to be sent
  headers: {
    'Accept': 'application/vnd.api+json',
    'X-Requested-With': 'XMLHttpRequest',
  },

  // `timeout` specifies the number of milliseconds before the request times out.
  // If the request takes longer than `timeout`, the request will be aborted.
  timeout: 120000,

  // `withCredentials` indicates whether or not cross-site Access-Control requests
  // should be made using credentials
  withCredentials: true,

  // `responseType` indicates the type of data that the server will respond with
  // options are 'arraybuffer', 'blob', 'document', 'json', 'text', 'stream'
  responseType: 'json', // default

  // `xsrfCookieName` is the name of the cookie to use as a value for xsrf token
  xsrfCookieName: 'XSRF-TOKEN', // default

  // `xsrfHeaderName` is the name of the http header that carries the xsrf token value
  xsrfHeaderName: 'X-XSRF-TOKEN', // default
}

$(document).ready(() => {
  let $accountSelector = $('select[name=ad_account_id]')
  let $campaignSelector = $('select[name=campaign_id]')
  let $listCampaigns = $('#list-campaigns')
  let $btnAddCampaigns = $('#add-campaigns')
  let chart = new Chart('chart', {
    scales: {
      yAxes: [{
        labelString: '',
        ticks: {
          beginAtZero: true
        }
      }]
    }
  })

  let refreshChar = () => {
    let campaignIds = []
    let chartType = $('a[data-type].active').attr('data-type')

    $listCampaigns.find('input[name="campaign[]"]:checked').each((i,e) => {
      campaignIds.push($(e).val())
    })

    console.log('chart.draw', chartType, campaignIds)
    chart.draw(chartType, campaignIds)
  }

  let addCampaignOption = campaign => {
    chart.addCampaign(campaign)
    $(`<option value="${campaign.id}">${campaign.name}</option>`)
      .appendTo($campaignSelector)
  }

  //
  let addSelectedCampaign = campaignId => {
    if ($listCampaigns.find(`li[data-id="${campaignId}"]`).length > 0) {
      return
    }

    let campaign = chart.getCampaign(campaignId)

    $(`<tr data-id="${campaignId}"></tr>`)
      .append(`<td><input type="checkbox" name="campaign[]" value="${campaign.id}" class="center-block"></td>`)
      .append(`<td>${campaign.name}</td>`)
      .append(`<td><button type="button" data-action="delete" class="btn btn-danger" data-id="${campaign.id}"><i class="fa fa-trash"></i></button></td>`)
      .appendTo($listCampaigns)
  }

  let removeSelectedCampaign = campaignId => {
    $listCampaigns.find(`tr[data-id="${campaignId}"]`).remove()
    refreshChar()
  }

  // Handle when AdAccount change
  $accountSelector.on('change', e => {
    console.log('$accountSelector.change', e)
    $campaignSelector.prop('disabled', true)

    axios.get('/prime-projects/facebook/' + e.target.value + '/campaigns')
      .then(response => {
        $campaignSelector.find('option:not([value=""])').remove()

        if (Array.isArray(response.data)) {
          $.each(response.data, (index, campaign) => addCampaignOption(campaign))
          $campaignSelector.prop('disabled', false)
        }
      })
  })

  // Handle when Campaign change
  $campaignSelector.on('change', e => {
    console.log('$campaignSelector.change', e)
    $btnAddCampaigns.prop('disabled', false)
  })

  // Handle when add Campaign
  $btnAddCampaigns.on('click', e => {
    console.log('$btnAddCampaigns.click', e)
    let $selectedCampaign = $campaignSelector.find('option:selected').first()
    addSelectedCampaign($selectedCampaign.attr('value'))
    $btnAddCampaigns.prop('disabled', true)
  })

  $(document).on('change', 'input[name="campaign[]"]', e => {refreshChar()})
  $(document).on('click', 'button[data-id]', e => {
    $(e.target).parents('li[data-id]').remove()

    // TODO: check selected campaign
    $btnAddCampaigns.prop('disabled', false)
    refreshChar()
  })
  $(document).on('click', 'a[data-type]', e => {
    e.preventDefault()
    $('ul.nav a[data-type]').removeClass('active')
    $(e.target).addClass('active')
    refreshChar()
  })
  $(document).on('click', '[data-action="delete"]', function() {
      removeSelectedCampaign($(this).data('id'))
      setTimeout(function() {
          refreshChar();
      }, 200);
  })

  // Disable in begin
  $btnAddCampaigns.prop('disabled', true)
  $campaignSelector.prop('disabled', true)
})
