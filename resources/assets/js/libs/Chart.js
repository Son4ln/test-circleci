import axios from 'axios'
import ChartJS from 'chart.js'
import moment from 'moment'
import {isDefined} from './utils'

export default class Chart {
  /**
   * Constructor
   *
   * @param {string} elementId
   * @param {object} [options]
   */
  constructor(elementId, options = {}) {
    /**
     * List campaigns
     *
     * @type {object}
     * @private
     */
    this.campaigns = {}

    /**
     * List sticks
     *
     * @type {object}
     */
    this.sticks = Chart.makeSticks()

    /**
     * Chart instance
     *
     * @type {Chart}
     * @private
     */
    this.chart = new ChartJS(elementId, {
      type: 'line',
      data: {
        labels: Object.keys(this.sticks),
        datasets: [],
      },
      options
    })
  }

  /**
   * Add campaign
   *
   * @param {object} campaign
   * @public
   */
  addCampaign(campaign) {
    if (isDefined(campaign.id) && !isDefined(this.campaigns[campaign.id])) {
      this.campaigns[campaign.id] = campaign
    }
  }

  /**
   * Check has campaign by ID
   *
   * @param {string} campaignId
   * @return {boolean}
   * @public
   */
  hasCampaign(campaignId) {
    return isDefined(this.campaigns[campaignId])
  }

  /**
   * Check has insights
   *
   * @param {string} campaignId
   * @return {boolean}
   * @public
   */
  hasInsights(campaignId) {
    if (!this.hasCampaign(campaignId)) {
      throw new Error(`Campaign #${campaignId} not exists`)
    }

    return isDefined(this.campaigns[campaignId]['insights'])
  }

  /**
   * Load insights for campaigns
   *
   * @param {string} campaignId
   * @return {Promise}
   * @private
   */
  loadCampaign(campaignId) {
    if (this.hasInsights(campaignId)) {
      return new Promise(resolve => {
        setTimeout(() => {
          resolve(this.getCampaign(campaignId))
        }, 1)
      })
    }

    return axios.get(`/prime-projects/facebook/${campaignId}/insights`)
      .then(response => {
        this.campaigns[campaignId]['insights'] = response.data

        return this.getCampaign(campaignId)
      })
  }

  /**
   * Get campaign data
   *
   * @param {string} campaignId
   * @return {object|undefined}
   * @public
   */
  getCampaign(campaignId) {
    return this.campaigns[campaignId]
  }

  /**
   * Redraw chart
   *
   * @param {string} type
   * @param {array} campaignIds
   * @return {Promise}
   * @public
   */
  draw(type, campaignIds) {
    if (!Array.isArray(campaignIds)) {
      throw new Error('The second argument MUST is an array')
    }

    return Promise.all(campaignIds.map(campaignId => (this.loadCampaign(campaignId))))
      .then(campaigns => {
        this.chart.data.datasets = campaigns.map(campaign => (Chart.campaignToDataset(type, campaign, this.sticks)))
        this.chart.update()
      })
  }

  /**
   * Format campaign to dataset
   *
   * @param {string} type
   * @param {object} campaign
   * @return {object}
   * @private
   */
  static campaignToDataset(type, campaign, sticks) {
    let data = Object.assign({}, sticks)
    for (let insight of campaign.insights) {
      if (isDefined(insight[type]) && data.hasOwnProperty(insight.date_stop)) {
        data[insight.date_stop] = insight[type]
      }
    }

    return {
      label: campaign.name,
      fill: false,
      data: Object.values(data),
    }
  }

  /**
   * Make labels
   *
   * @return {object}
   * @private
   */
  static makeSticks() {
    let sticks = {}
    const start = moment().subtract(13, 'days').startOf('day')
    for (let i = 0; i < 14; i++) {
      sticks[start.clone().add(i, 'days').format('YYYY-MM-DD')] = 0
    }

    return sticks
  }
}
